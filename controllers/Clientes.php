<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Clientes extends Buster_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('client_m');
		$this->data['page_script'] = 'user/js/clients';
	}


	public function index()
	{

		$perpage = 10;
		$total_clientes = $this->db2->where('id_cliente!=', 0)->get('clientes')->num_rows();
		$clientes = $this->client_m->get_all();
		$this->data['total_pages'] = ceil($total_clientes / $perpage);
		$this->data['clientes'] = $clientes;
		$this->data['total_clientes'] = $total_clientes;
		$this->data['mainview'] = 'user/client/main_view';

		$this->load->view('user/template/main_body', $this->data);
	}

	public function ver($id)
	{

		$cliente = $this->client_m->get_single($id);
		if (!empty($cliente)) {
			$contactos =  $this->client_m->get_contactos($id, 1);
			$this->data['total_c_pages'] = ceil($contactos['count'] / 3);
			$this->data['contactos'] = $contactos;
			$this->data['cliente_id'] = $cliente->id_cliente;
			$this->data['cliente'] = json_encode($cliente);
			$this->data['años_fiscales'] = $this->client_m->fiscal_year($id);
			$this->data['mainview'] = 'user/client/single';
			$this->load->view('user/template/main_body', $this->data);
		} else {
			redirect('clientes');
		}
	}

	public function nuevo()
	{
		//ON SUBMIT
		$action = $this->input->post('action');
		if (!empty($action) && $action == 'submit') {
			$rules = $this->client_m->create_new;
			$this->form_validation->set_rules($rules);
			$data = $this->client_m->array_from_post(array(
				'nombre_cliente', 'telefono_cliente', 'direccion_cliente',
				'email_cliente', 'cif', 'poblacion_cliente', 'cp_cliente', 'provincia_cliente'
			));
			if ($this->form_validation->run() == FALSE) {
				echo json_alert('error', 'warning', validation_errors());
				return FALSE;
			}
			$data['date_added'] = date("Y-m-d H:i:s");
			if ($this->client_m->guardar(null, $data) == FALSE) {
				echo json_alert('error', 'warning', 'No se han realizado cambios en los datos, error en los campos');
				return FALSE;
			}
			$new_id = $this->client_m->last_id();
			$location = 'clientes/ver/' . $new_id;
			echo json_alert('success', 'success', 'Cliente agregado! Redirigiendo a edición...', 'client_id', $location);
			return TRUE;
		} else {
			$this->data['mainview'] = 'user/client/edit_new';
			$this->load->view('user/template/main_body', $this->data);
		}
	}


	public function nuevo_en_doc()
	{

		$rules = $this->client_m->create_new;
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == TRUE) {

			$data = $this->client_m->array_from_post(
				array(
					'nombre_cliente',
					'telefono_cliente',
					'direccion_cliente',
					'email_cliente',
					'cif', 'poblacion_cliente', 'cp_cliente', 'provincia_cliente'
				)
			);

			$data['date_added'] = date("Y-m-d H:i:s");
			if ($this->client_m->guardar(null, $data) == TRUE) {

				$client_id = $this->client_m->last_id();
				$client_info = $this->client_m->get_single($client_id);
				//SI SE USA EN EDICION DE DOCUMENTO, ASIGNA EL NUEVO CLIENTE A ESTE DOCUMENTO
				if (!empty($_POST['add']) && $_POST['add'] == 'true') {
					$id_factura = $_POST['id_factura'];
					$this->client_m->cliente_a_factura($client_id, $id_factura);
				}

				$data = array(
					'result' => 'success',
					'msg' => alert_msg('Nuevo cliente agregado!', 'success'),
					'client' => json_encode($client_info)
				);
				echo json_encode($data);
			} else {
				$errors = 'No se han realizado cambios en los datos, error en los campos';
				$data = array('result' => 'error', 'msg' => alert_msg($errors, 'info'));
				echo json_encode($data);
			}
		} else {
			$errors = validation_errors();
			$data = array('result' => 'error', 'msg' => alert_msg($errors, 'warning'));
			echo json_encode($data);
		}
	}

	public function editar($id)
	{

		$client = $this->client_m->get_single($id);
		$this->session->set_userdata('edit_user', $id);

		if (!empty($client)) {
			//ON SUBMIT
			$action = $this->input->post('action');
			if (!empty($action) && $action == 'submit') {

				$rules = $this->client_m->create_new;
				$this->form_validation->set_rules($rules);
				if ($this->form_validation->run() == TRUE) {

					$data = $this->client_m->array_from_post(array(
						'nombre_cliente', 'telefono_cliente', 'direccion_cliente',
						'email_cliente', 'cif', 'poblacion_cliente', 'cp_cliente', 'provincia_cliente'
					));

					if ($this->client_m->guardar($id, $data) == TRUE) {
						$client_info = $this->client_m->get_single($id);
						$message = alert_msg('Datos actualizados!', 'success');
						$data = array(
							'result' => 'success',
							'client' => json_encode($client_info),
							'msg' => $message
						);
						echo json_encode($data);
					} else {
						$errors = 'No se han realizado cambios en los datos';
						$data = array('result' => 'error', 'msg' => alert_msg($errors, 'info'));
						echo json_encode($data);
					}
				} else {
					$errors = validation_errors();
					$data = array('result' => 'error', 'msg' => alert_msg($errors, 'warning'));
					echo json_encode($data);
				}
			}
		} else {
			redirect('clientes');
		}
	}


	public function nuevo_contacto($id_cliente)
	{

		$rules = $this->client_m->p_contacto;
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == TRUE) {

			$data = $this->client_m->array_from_post(
				array(
					'nombre',
					'telefono',
					'email',
					'cargo'
				)
			);
			$data['client_id'] = $id_cliente;
			$data['date_added'] = date("Y-m-d H:i:s");
			if ($this->client_m->guardar_contacto(null, $data) == TRUE) {

				$data = array(
					'result' => 'success',
					'msg' => alert_msg('Persona de contacto agregada!', 'success')
				);
				echo json_encode($data);
			} else {
				$errors = 'No se han realizado cambios, error en los campos';
				$data = array('result' => 'error', 'msg' => alert_msg($errors, 'warning'));
				echo json_encode($data);
			}
		} else {
			$errors = validation_errors();
			$data = array('result' => 'error', 'msg' => alert_msg($errors, 'warning'));
			echo json_encode($data);
		}
	}

	public function editar_contacto($id)
	{

		$rules = $this->client_m->p_contacto;
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == TRUE) {

			$data = $this->client_m->array_from_post(
				array(
					'nombre',
					'telefono',
					'email',
					'cargo'
				)
			);

			if ($this->client_m->guardar_contacto($id, $data) == TRUE) {

				$data = array(
					'result' => 'success',
					'msg' => alert_msg('Contacto modificado!', 'success')
				);
				echo json_encode($data);
			} else {
				$errors = 'No se han realizado cambios.';
				$data = array('result' => 'error', 'msg' => alert_msg($errors, 'info'));
				echo json_encode($data);
			}
		} else {
			$errors = validation_errors();
			$data = array('result' => 'error', 'msg' => alert_msg($errors, 'warning'));
			echo json_encode($data);
		}
	}


	//HELPERS
	function contactos_table($id, $page)
	{
		$btn = $this->input->post('btn');
		$contactos = $this->client_m->get_contactos($id, $page);
		$this->data['contactos'] = $contactos;
		$total_c_pages = ceil($contactos['count'] / 3);
		if ($btn == 1) {
			$this->data['contact_script'] = '<script>pagination_contact(0,' . $total_c_pages . ')</script>';
		}
		$this->load->view('user/client/contactos', $this->data);
	}

	public function load_doc($doc, $id)
	{
		if ($doc == 'presupuesto') {
			if ($this->data['user']->plan_id == 'SLIV_001' || $this->data['user']->plan_id == 'SLIV_004') {
				return FALSE;
			}
		}
		$btn = $this->input->post('btn');
		$page = $this->input->post('page');
		$perpage = 10;
		$filter['estado'] = $this->input->post('estado');
		$filter['fecha'] = $this->input->post('fecha');
		$filter['id_cliente'] = $id;
		$docs = $this->client_m->get_docs($doc, $filter, $page);
		$estado_pagado = 'Pagado';		
		switch($doc) {
			case 'abono':
				$estado_pagado = 'Abonado';
				break;
			case 'presupuesto':
				$estado_pagado = 'Aprovado';
				break;
		}
        $this->data['estado_pagado'] = $estado_pagado;
		$this->data['documento'] = $doc;
		$this->data['negative'] =  ($doc == 'abono') ? '- ' : '';
		$this->data['docs'] = $docs;		
		$total = ceil($docs['count'] / $perpage);
		$this->data['total_docs'] = $docs['count'];
	
		if ($btn == 1) {
			$this->data['script'] = '<script> doc_pagination(' . $page . ',' . $total . ',"' . $doc . '"); </script>';
		}
		$this->load->view('user/client/documents_table', $this->data);
	}

	public function buscar()
	{

		$btn = $this->input->post('btn');
		$page = $this->input->post('page');
		$perpage = 10;
		$filter = $this->input->post('filter');
		$clientes = $this->client_m->get_all($filter, $page);
		$total = ceil($clientes['count'] / $perpage);

		if ($btn == 1) {
			$this->data['script'] = '<script> pagination(' . $page . ',' . $total . '); </script>';
		}
		$this->data['clientes'] = $clientes;
		$this->load->view('user/client/main_table', $this->data);
	}

	function page_buttons($page, $total_pages)
	{
		if (!isset($page)) {
			$page = 0;
		}
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
		$doc = $this->input->post('doc');

		if (in_array($doc, config_item('doc_type'))) {

			$this->data['id'] = $this->input->post('id');
			$this->data['doc_type'] = $doc;
			$this->load->view('user/client/client_pagination', $this->data);
		} else {
			$this->load->view('user/components/pagination', $this->data);
		}
	}

	function page_buttons_contact($page, $total_pages)
	{

		if (!isset($page)) {
			$page = 0;
		}
		$left_pages = $total_pages - $page;
		if ($total_pages == 1) {
			$left_pages = 0;
		} else {
			if ($left_pages <= 1) {
				$left_pages = $total_pages;
				$page = $total_pages - 3;
				if ($page < 0) $page = 0;
			}
		}
		$next_pages = $page + 3;
		$back = $next_pages - 5;
		if ($back < 0) {
			$back = 0;
		}

		$this->data['back'] = $back;
		$this->data['page'] = $page;
		$this->data['next_pages'] = $next_pages;
		$this->data['left_pages'] = $left_pages;
		$this->data['total_c_pages'] = $total_pages;

		$this->load->view('user/client/contact_pagination', $this->data);
	}

	function eliminar()
	{
		$id = intval($_POST['id']);
		if (!empty($id)) {
			if ($this->client_m->eliminar_cliente($id) == FALSE) {
				echo json_alert('error', 'warning', 'Este cliente no se puede elimiar porque esta asociado a un documento.');
				return FALSE;
			}
			echo json_alert('success', 'success', 'Cliente eliminado');
			return TRUE;
		}
	}

	function eliminar_contacto()
	{

		$id = intval($_POST['id']);
		if (!empty($id)) {
			if ($this->client_m->eliminar_contacto($id) == TRUE) {
				$message = alert_msg('Contacto eliminado', 'success');
			} else {
				$message = alert_msg('Error, recargue la aplicacion', 'warning');
			}
			echo $message;
		}
	}

	//RULES 
	function _unique_client_name()
	{
		return $this->rules_m->_unique_client_name();
	}
	function _unique_cif()
	{
		return $this->rules_m->_unique_cif();
	}
	function _unique_contact_name()
	{
		return $this->rules_m->_unique_contact_name();
	}
}
