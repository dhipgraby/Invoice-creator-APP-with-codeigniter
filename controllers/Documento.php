<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Documento extends Buster_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('documents_m');
		$this->data['page_script'] = 'user/js/documents';
	}

	public function main($doc)
	{
		if (!in_array($doc, config_item('doc_type'))) {
			redirect('dashboard');
		}
		if ($doc == 'presupuesto') {
			if ($this->data['user']->plan_id == 'SLIV_001' || $this->data['user']->plan_id == 'SLIV_004') {
				redirect('dashboard');
			}
		}

		$this->main_data($doc);
		$this->data['mainview'] = 'user/documents/index';
		$this->load->view('user/template/main_body', $this->data);
	}

	function main_data($doc)
	{
		$facturas = $this->documents_m->get_docs($doc, null, 1);
		$perpage = 10;
		$plural_docname = $doc . 's';
		$this->data['pagetitle'] = $doc;
		$this->data['perpage'] = $perpage;
		$this->data['años_fiscales'] = $this->documents_m->fiscal_year($doc);
		$this->data['total_pages'] = ceil($facturas['count'] / $perpage);
		$this->data['docs'] = $facturas;
		$this->data['plural_docname'] = $plural_docname;
		$this->data['documento'] = $doc;
		$this->data['negative'] =  ($doc == 'abono') ? '- ' : '';
	}

	function editar($doc, $id)
	{

		if (!in_array($doc, config_item('doc_type'))) {
			redirect('dashboard');
		}
		if ($doc == 'presupuesto') {
			if ($this->data['user']->plan_id == 'SLIV_001' || $this->data['user']->plan_id == 'SLIV_004') {
				redirect('dashboard');
			}
		}
		$current_doc = $this->db2->where('documento', $doc)
			->where('id_factura', $id)
			->get('facturas')->row();
		if (empty($current_doc)) {
			redirect('dashboard');
		}
		$this->edit_data($current_doc, $doc, $id);
		$this->data['mainview'] = 'user/documents/edit';
		$this->load->view('user/template/main_body', $this->data);
	}

	function edit_data($current_doc, $doc, $id)
	{

		$id_factura = $current_doc->id_factura;
		$stats = $this->documents_m->get_details($id_factura);
		$detalles = $this->documents_m->get_detalle_factura($current_doc->id_factura, null);
		$facturado = $this->db2->where('old_id', $id_factura)
			->where('documento', 'factura')
			->get('facturas')->row();
		$this->load->model('payment_m');
		$payments = $this->payment_m->get_methods();
		$this->data['bancos'] = $payments['bancos'];
		$this->data['paypals'] = $payments['paypals'];
		$this->data['info'] = $stats;
		$this->data['id_factura'] = $id;
		$this->data['current_doc'] = $current_doc;
		$this->data['numero_factura'] = $current_doc->numero_factura;
		$this->data['id_doc'] = $id_factura;
		$this->data['facturado'] = !empty($facturado) ? TRUE : FALSE;
		$this->data['documento'] = $doc;
		$this->data['negative'] =  ($doc == 'abono') ? '- ' : '';
		$this->data['partidas'] = $this->documents_m->get_partidas($id_factura);
		$this->data['detalles'] = $detalles;
		$this->data['sortable'] = TRUE;
		$this->data['users'] = $this->documents_m->get_users();
		$this->data['add_client'] = 'true';
		$this->total_calc($detalles, $current_doc->iva);
	}

	function guardar_notas($id)
	{
		$notas = $_POST['notas'];
		$this->db2->set('notas', $notas)->where('id_factura', $id)->update('facturas');
		$error = 'No se han realizado cambios en las notas';
		$msg = 'Datos guardados correctamente';

		echo ($this->db2->affected_rows() > 0) ? alert_msg($msg, 'success') : alert_msg($error, 'info');
	}

	function guardar($id)
	{

		$documento = $_POST['documento'];
		$id_cliente = intval($_POST['id_cliente']);
		$id_vendedor = $_POST['id_vendedor'];
		$condiciones = $_POST['condiciones'];
		$notas = $_POST['notas'];
		$direccion = $_POST['direccion'];
		$proyecto = $_POST['proyecto'];
		$iva = $_POST['iva'];
		$estado_factura = intval($_POST['estado_factura']);
		$fecha_factura = date("Y-m-d", strtotime($_POST['fecha'])).' '.date('h:i');
		$vencimiento = date("Y-m-d", strtotime($_POST['fecha_vencimiento']));	
		$rules = $this->documents_m->create_new;
		if ($documento != 'abono') {
			$rules['n_original'] = NULL;
		}
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == FALSE) {
			$errors = validation_errors();
			echo alert_msg($errors, 'warning');
			return FALSE;
		}

		$data = array(

			'id_cliente' => $id_cliente,
			'id_vendedor' => $id_vendedor,
			'condiciones' => $condiciones,
			'estado_factura' => $estado_factura,
			'direccion_proyecto' => $direccion,
			'proyecto' => $proyecto,
			'iva' => $iva,
			'fecha_factura' => $fecha_factura,
			'vencimiento' => $vencimiento,
			'notas' => $notas,
		);

		if ($condiciones == 3 || $condiciones == 4) {

			$data['id_payment'] = $_POST['id_payment'];
		}
		if ($documento == 'abono') {
			$data['n_original'] = intval($_POST['n_original']);
		}
		if ($this->documents_m->guardar($id, $data) == FALSE) {
			$errors = 'No se han realizado cambios';
			echo alert_msg($errors, 'info');
			return FALSE;
		}

		$message = alert_msg('Datos actualizados!', 'success');
		echo $message;
		return TRUE;
	}

	function create_new($doc)
	{
		if (!in_array($doc, config_item('doc_type'))) {
			redirect('dashboard');
		}
		if ($doc == 'presupuesto') {
			if ($this->data['user']->plan_id == 'SLIV_001' || $this->data['user']->plan_id == 'SLIV_004') {
				redirect('dashboard');
			}
		}
		$this->create_data($doc);
		$this->data['mainview'] = 'user/documents/create';
		$this->load->view('user/template/main_body', $this->data);
	}

	function create_data($doc)
	{
		if (empty($this->documents_m->last_id($doc))) {
			$this->data['init_num'] = TRUE;
		}
		$this->load->model('payment_m');
		$payments = $this->payment_m->get_methods();
		$this->data['bancos'] = $payments['bancos'];
		$this->data['paypals'] = $payments['paypals'];
		$plural_docname = $doc . 's';
		$this->data['plural_docname'] = $plural_docname;
		$this->data['documento'] = $doc;
		$this->data['add_client'] = 'false';
		$this->data['users'] = $this->documents_m->get_users();
	}


	function create()
	{
		//Variables por GET
		$documento = $_POST['documento'];
		$init_num = $_POST['init_num'];
		$id_cliente = intval($_POST['id_cliente']);
		$id_vendedor = $_POST['id_vendedor'];
		$direccion = $_POST['direccion'];
		$proyecto = $_POST['proyecto'];
		$condiciones = $_POST['condiciones'];
		$date = date("Y-m-d", strtotime($_POST['fecha'])).' '.date('h:i');
		$vencimiento = date("Y-m-d", strtotime($_POST['fecha_vencimiento']));		
		$last_id = intval($this->documents_m->last_id($documento)) + 1;

		$numero_factura = $last_id;
		if ($numero_factura == 1) {
			$numero_factura = $init_num;
		}

		$rules = $this->documents_m->create_new;
		if ($documento != 'abono') {
			$rules['n_original'] = null;
		}
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == FALSE) {
			echo json_alert('error', 'warning', validation_errors());
			return FALSE;
		}
		$data = array(

			'documento' => $documento,
			'numero_factura' => $numero_factura,
			'id_cliente' => $id_cliente,
			'id_vendedor' => $id_vendedor,
			'direccion_proyecto' => $direccion,
			'proyecto' => $proyecto,
			'condiciones' => $condiciones,
			'fecha_factura' => $date,
			'vencimiento' => $vencimiento,

		);

		if ($condiciones == 3 || $condiciones == 4) {

			$data['id_payment'] = $_POST['id_payment'];
		}

		if ($documento == 'abono') {
			$data['n_original'] = intval($_POST['n_original']);
		}
		if ($this->documents_m->create_new($data) == FALSE) {
			echo json_alert('error', 'warning', 'Error al crear este documento, recargue la aplicación');
			return FALSE;
		}

		$max_id = $this->documents_m->max_id($documento);
		echo json_alert('success', 'success', 'Documento creado! Redirigiendo a su edición...', 'max_id', $max_id);
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

	function clientes()
	{
		$like = $_GET['term'];
		if (empty($like)) {
			return FALSE;
		}
		echo json_encode($this->documents_m->get_clients($like));
	}

	//FUNCTION PARA FACTURAR PRESUPUESTOS O ABONAR FACTURAS
	//copia los datos seleccionados de partidas o productos.
	function copiar($id)
	{

		$current_doc = $this->db2->where('id_factura', $id)->get('facturas')->row();
		$ids = json_decode($_POST['ids']);

		if (!isset($_POST['ids']) || empty($ids)) {
			$errors = 'Ningún producto seleccionado.';
			echo alert_msg($errors, 'warning');
			return FALSE;
		}

		$ids = json_decode($_POST['ids']);
		$detalles = $this->documents_m->get_detalles_array($ids);
		$valid_pro = $this->documents_m->_valid_product($detalles, $id);

		if (empty($valid_pro)) {
			$errors = 'Algun producto seleccionado ya ha sido copiado.';
			echo alert_msg($errors, 'warning');
			return FALSE;
		}

		if (empty($current_doc) || $current_doc->documento == 'abono' || $current_doc->documento == 'proforma') {
			$errors = 'Acción no disponible en este documento.';
			echo alert_msg($errors, 'warning');
			return FALSE;
		}
		if ($this->documents_m->copiar($current_doc, $detalles) == FALSE) {
			$errors = 'Error al copiar este documento. Intente de nuevo o contacte a soporte.';
			echo alert_msg($errors, 'warning');
			return FALSE;
		}
		$doc_name = ($current_doc->documento == 'factura') ? 'abono' : 'factura';
		$next_id = $this->documents_m->max_id($doc_name);
		$message = alert_msg('Documento creado! Redirigiendo a su edicion.', 'success');
		$location = base_url('editar/' . $doc_name . '/' . $next_id);
		$script = "<script>
				   window.setTimeout(function() {
						window.location = '" . $location . "';
					  }, 3000);
					</script>";
		echo $message . $script;
	}

	function copiar_form($id)
	{

		$current_doc = $this->db2->where('id_factura', $id)->get('facturas')->row();
		if (empty($current_doc)) {
			echo alert_msg('Documento no encontrado.', 'warning');
			return FALSE;
		}

		$id_factura = $current_doc->id_factura;
		$detalles = $this->documents_m->get_detalle_factura($current_doc->id_factura, null);
		$this->data['documento'] = $current_doc->documento;
		$this->data['partidas'] = $this->documents_m->get_partidas($id_factura);
		$this->data['detalles'] = $detalles;

		$this->load->view('user/documents/abonos/datos_abonos', $this->data);
	}

	function borrar_doc($id)
	{
		if (!empty($id)) {
			if ($this->documents_m->borrar_doc($id) == TRUE) {
				$message = alert_msg('Documento eliminado', 'success');
			} else {
				$message = alert_msg('Error, recargue la aplicacion', 'warning');
			}
			echo $message;
		}
	}
	function vaciar_doc($id)
	{
		if (!empty($id)) {
			if ($this->documents_m->vaciar_doc($id) == TRUE) {
				$message = alert_msg('Información y detalles vaciados', 'success');
			} else {
				$message = alert_msg('Este documento ya ha sido vaciado...', 'info');
			}
			echo $message;
		}
	}

	//HELPERS

	public function buscar()
	{
		$docname = $this->input->post('documento');
		if ($docname == 'presupuesto') {
			if ($this->data['user']->plan_id == 'SLIV_001' || $this->data['user']->plan_id == 'SLIV_004') {
				return FALSE;
			}
		}
		$btn = $this->input->post('btn');
		$page = $this->input->post('page');
		$perpage = 10;

		$filter = $this->input->post('filter');
		$estado = $this->input->post('estado');
		$fecha =  $this->input->post('fecha');
		$data = array(
			'fecha' => $fecha,
			'filter' => $filter,
			'estado' => $estado,
		);
		$docs = $this->documents_m->get_docs($docname, $data, $page);
		$this->data['documento'] = $docname;
		$this->data['negative'] =  ($docname == 'abono') ? '- ' : '';
		$this->data['docs'] = $docs;
		$total = ceil($docs['count'] / $perpage);
		if ($btn == 1) {
			$this->data['script'] = '<script> pagination(' . $page . ',' . $total . '); </script>';
		}
		$this->load->view('user/documents/main_table', $this->data);
	}

	function page_buttons($page = null, $total_pages = null)
	{

		$perpage = 10;
		if (!isset($page)) {
			$page = 0;
		};
		$left_pages = $total_pages - $page;
		if ($total_pages == 1) {
			$left_pages = 0;
		} else {
			if ($left_pages <= 1) {
				$left_pages = $total_pages;
				$page = $total_pages - 5;
				if ($page < 0) $page = 0;
			}
		}
		$next_pages = $page + 5;
		$back = $next_pages - 10;

		if ($back < 0) {
			$back = 0;
		}

		$this->data['back'] = $back;
		$this->data['page'] = $page;
		$this->data['next_pages'] = $next_pages;
		$this->data['left_pages'] = $left_pages;
		$this->data['total_pages'] = $total_pages;
		$this->load->view('user/components/pagination', $this->data);
	}

	//RULES

	function _valid_doc()
	{

		if (!in_array($_POST['documento'], config_item('doc_type'))) {
			$this->form_validation->set_message('_valid_doc', 'Documento invalido, recargue la pagina');
			return FALSE;
		}
		return TRUE;
	}

	function _valid_client()
	{

		$id = $this->input->post('id_cliente');
		$client = $this->db2->where('id_cliente', $id)->get('clientes')->result();
		if (!count($client)) {
			$this->form_validation->set_message('_valid_client', 'Cliente no encontrado, seleccione uno al escribir o cree uno nuevo');
			return FALSE;
		} else {
			return TRUE;
		}
	}
}
