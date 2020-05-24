<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Productos extends Buster_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('productos_m');
        $this->load->model('documents_m');
    }


    
	//PRODUCTOS

	function nuevo_producto($id)
	{

		$rules = $this->productos_m->productos;
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == TRUE) {


			$data = array(
				'date_added' => date("Y-m-d H:i:s"),			
				'nombre_producto' => $_POST['nombre_producto'],
				'tipo' => $_POST['tipo'],
				'precio_producto' => $_POST['precio_producto'],
			);
			if ($this->productos_m->nuevo_producto($data, $id, $_POST['id_partida'], $_POST['cantidad']) == TRUE) {
				echo json_alert('success', 'success', 'Producto agregado');
			} else {				
				echo json_alert('error', 'warning','Error en los campos.');
			}
		} else {			
			echo json_alert('error', 'warning',validation_errors());
		}
	}

	function product_form($id)
	{

		$id_producto = $_POST['id_producto'];
		$detalles = $this->documents_m->get_detalle_factura($id, $id_producto);
		$this->data['single_detail'] = json_encode($detalles);
		$this->load->view('user/modal/documentos/product_form', $this->data);
	}

	function editar_producto($id)
	{

		$id_producto = $this->input->post('id_producto');
		$rules = $this->productos_m->productos;

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == TRUE) {

			$array_producto = array(
				'nombre_producto' => $_POST['nombre_producto'],
				'tipo' => $_POST['tipo'],
				'precio_producto' => $_POST['precio_producto'],
			);
			$detalles = array(
				'cantidad' =>  $_POST['cantidad'],
				'precio_venta' => $_POST['precio_producto'],
			);
			$editar_detalle = $this->documents_m->editar_detalle($detalles, $id, $id_producto);
			$editar_producto = $this->productos_m->editar_producto($array_producto, $id_producto);

			if ($editar_detalle == TRUE || $editar_producto == TRUE) {
				$message = 'Producto modificado';
				echo json_alert('success', 'success', $message);
			} else {
				$message = 'No se ha realizado ningun cambio.';
				echo json_alert('error', 'info', $message);
			}
		} else {
			$message = validation_errors();
			echo json_alert('error', 'warning', $message);
		}
	}

    function borrar_producto(){
        if(!isset($_POST['id'])) { return FALSE; }
        
			$id_detalle = intval($_POST['id']);
			$id_producto = $this->input->post('id_producto');
			if ($this->productos_m->borrar_producto($id_detalle, $id_producto) == FALSE) {
                $message = alert_msg('Error, recargue la aplicacion', 'warning');
            return FALSE;
            } 
            $message = alert_msg('Producto eliminado', 'success');			
			echo $message;
		
    }
}
