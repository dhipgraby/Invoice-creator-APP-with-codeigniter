<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Buster_Controller
{

   function __construct()
   {
      parent::__construct();
      $this->load->model('documents_m');
   }

   public function index()
   {
      $this->data['pagetitle'] = 'Dashboard';
      $facturas = $this->documents_m->get_stats(null);
      $cuenta = $this->db2->limit(1)->get('perfil')->row();
      if($cuenta->nombre_empresa == 'NOMBRE EMPRESA') {
         $this->data['message'] = alert_msg('Configura tu cuenta en <a href="' . base_url('cuenta') . '">Ajustes</a> para comenzar a facturar', 'info');
      }
      $this->data['docs'] = $facturas;
      $this->data['mainview'] = 'user/dashboard';
      $this->load->view('user/template/main_body', $this->data);
   }  

   
}
