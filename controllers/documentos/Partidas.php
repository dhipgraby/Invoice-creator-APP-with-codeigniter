<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Partidas extends Buster_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('partidas_m');
        $this->load->model('documents_m');
    }

    function nueva_partida($id)
    {

        $rules = $this->partidas_m->partidas;
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == TRUE) {

            $data = array(
                'datecreate' => date("Y-m-d H:i:s"),
                'nombre_partida' => $_POST['partida'],
                'numero_factura' => $id,
            );

            if ($this->partidas_m->nueva_partida($data) == TRUE) {
                $message = 'Partida creada!';
                echo json_alert('success', 'success', $message);
            } else {
                $message = 'Error en los campos.';
                echo json_alert('error', 'warning', $message);
            }
        } else {
            $errors = validation_errors();
            echo json_alert('error', 'warning', $errors);
        }
    }

    function editar_partida($id)
    {

        $rules = $this->partidas_m->partidas;
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_alert('error', 'warning', $errors);
            return FALSE;
        }

        $nombre = $_POST['partida'];

        if($this->partidas_m->editar_partida($id, $nombre) == FALSE) {
            $message = 'No se han realizado cambios.';
            echo json_alert('error', 'info', $message);
            return FALSE;
        
        }

        $message = 'Partida modificada!';
        echo json_alert('success', 'success', $message);
    }


    function update_partidas($id)
    {

        $current_doc = $this->db2->where('id_factura', $id)->get('facturas')->row();

        $iva = $current_doc->iva;
        $detalles = $this->documents_m->get_detalle_factura($current_doc->id_factura);

        $this->total_calc($detalles, $iva);

        $this->data['negative'] =  ($current_doc->documento == 'abono') ? '- ' : '';
        $this->data['partidas'] = $this->partidas_m->get_partidas($id);
        $this->data['detalles'] = $detalles;

        $this->db2->where('id_factura', $id)
            ->set('total_venta', $this->data['total_factura'])
            ->update('facturas');

        $this->load->view('user/documents/partidas', $this->data);
    }

    function borrar_partida()
    {
        if (!isset($_POST['id_partida'])) {
            return FALSE;
        }
        $id_partida = intval($_POST['id_partida']);

        if ($this->partidas_m->borrar_partida($id_partida) == FALSE) {
            $message = alert_msg('Error, recargue la aplicacion', 'warning');
            echo $message;
            return FALSE;
        }
        $message = alert_msg('Partida eliminado', 'success');
        echo $message;
    }

    	//ORDENAR PARTIDAS .
	public function save_order()
	{

		if (!isset($_POST['datos'])) { return FALSE; }
            
            $data = $_POST['datos'];
            $this->partidas_m->save_order($data);
			$msg = 'Orden de partidas actualizado.';
			echo alert_msg($msg, 'success');
		
	}

    
	public function load_partidas($id)
	{
		$partidas = $this->documents_m->get_partidas($id);
		$this->data['partidas'] = $partidas;
		$this->load->view('user/modal/documentos/partidas', $this->data);
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
        $impuesto = 21;
        if ($iva == 0) {
            $impuesto = 0;
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
