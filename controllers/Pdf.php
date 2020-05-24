<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;

class Pdf extends Buster_Controller
{

  public function __construct()
  {
    parent::__construct();
    require('dompdf/vendor/autoload.php');
    $this->load->model('documents_m');
    $this->load->model('account_m');
    $this->load->model('payment_m');
  }

  public function index($id)
  {     
    $pdf = new Dompdf();
    $this->datos_pdf($id);
    $template = ($this->data['user']->email == 'thecilsurf@gmail.com') ? 'english/basic_template_en' : 'pdf_doc';
    $html = $this->load->view('user/documents/pdf/'.$template, $this->data, TRUE);
    $pdf->setPaper(array(0, 1, 600, 700), 'portrait'); //x inicio, y inicio, ancho final, alto final
    $pdf->loadHtml($html);
    $pdf->render();
    // Output the generated PDF (1 = download and 0 = preview)
    $pdf->stream("documento" . $id . ".pdf", array("Attachment" => 0));
  }

  public function vista_html($id_factura)
  {    
    $factura = $this->db2->where('id_factura', $id_factura)
      ->get('facturas')->row();    
    $cliente =  $this->db2->where('id_cliente', $factura->id_cliente)
      ->get('clientes')->row();
    $this->data['cliente'] = $cliente;    

    $this->data['factura'] = $factura;
    $this->data['documento'] = $factura->documento;
    $detalles = $this->documents_m->get_detalle_factura($factura->id_factura);
    $this->total_calc($detalles, $factura->iva);
    $template = ($this->data['user']->email == 'thecilsurf@gmail.com') ? 'english/basic_template_en' : 'basic_template';
    $this->load->view('user/documents/pdf/'.$template, $this->data);
  }

  function datos_pdf($id)
  {
    $factura = $this->db2->where('id_factura', $id)->get('facturas')->row();
    $doc = $factura->documento;        
    if ($doc == 'abono') {
      $this->data['factura_original'] = $factura->n_original;
    }
    $detalles = $this->documents_m->get_detalle_factura($factura->id_factura);
    $this->data['payment_method'] = $this->payment_m->get_methods();
    $this->data['perfil'] = $this->account_m->get_perfil();
    $this->data['cliente'] =$this->db2->where('id_cliente', $factura->id_cliente)->get('clientes')->row();
    $this->data['partidas'] = $this->documents_m->get_partidas($factura->id_factura);
    $this->data['detalles'] = $detalles;
    $this->data['factura'] = $factura;
    $this->data['documento'] = $doc;
    $this->data['negative'] =  ($doc == 'abono') ? '- ' : '';
    $this->total_calc($detalles, $factura->iva);
  }

  public function download($id)
  {

    require('dompdf/vendor/autoload.php');
    $pdf = new Dompdf();
    $perfil = $this->account_m->get_perfil();
    $factura = $this->db2->where('id_factura', $id)
      ->get('facturas')->row();
    $doc = $factura->documento; 
    $cliente =  $this->db2->where('id_cliente', $factura->id_cliente)
      ->get('clientes')->row();

    $detalles = $this->documents_m->get_detalle_factura($factura->id_factura);
    $this->data['perfil'] = $perfil;
    $this->data['cliente'] = $cliente;
    $this->data['user'] = $user;
    $this->data['partidas'] = $this->documents_m->get_partidas($factura->id_factura);
    $this->data['detalles'] = $detalles;
    $this->data['factura'] = $factura;
    $this->data['documento'] = $doc;

    $html = $this->load->view('user/documents/pdf/pdf_doc', $this->data, TRUE);
    $pdf->loadHtml($html);
    $pdf->render();
    // Output the generated PDF (1 = download and 0 = preview)
    $pdf->stream("documento" . $id . ".pdf", array("Attachment" => 1));
  }

  function total_calc($detalles, $iva)
  {

    $sumador_total = 0;
    if (count($detalles)) {

      foreach ($detalles as $detalle) {
        $cantidad = $detalle['cantidad'];
        $precio_venta = $detalle['precio_venta'];
        $precio_total = $precio_venta * $cantidad;
        $sumador_total += $precio_total; //Sumador
      }
    }
    
    switch ($iva) {
			case 1:
				$impuesto = 21;
				break;
			case 2:
				$impuesto = 10;
				break;
			case 0:
				$impuesto = 0;
				break;
		}
    $subtotal = $sumador_total;
    $total_iva = ($subtotal * $impuesto) / 100;
    $total_factura = $subtotal + $total_iva;
    $this->data['subtotal'] = $subtotal;
    $this->data['total_iva'] = $total_iva;
    $this->data['total_factura'] = $total_factura;
    $this->data['iva'] = $iva;
  }
  
}
