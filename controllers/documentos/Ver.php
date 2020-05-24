<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ver extends Buster_Controller
{

	function __construct()
	{
		parent::__construct();				
    }
    
    public function index(){

        $this->data['mainview'] = 'user/documents/ver';
		$this->load->view('user/template/main_body', $this->data);   
    }

    public function get_detalles($id){
        $detalles = $this->db2->where('numero_factura',$id)->get('detalle_factura')->result();
        echo json_encode($detalles);
    }

    public function get_partidas($id){
        $partidas = $this->db2->where('numero_factura',$id)->get('partidas')->result();
        echo json_encode($partidas);
    }
}
