<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

	function __construct() {
      parent::__construct(); 
      $licencia = $this->session->licencia;
      if(!empty($licencia) && $licencia != 000000){
         $config_app = switch_db_dinamico($licencia);
         $this->db2 = $this->load->database($config_app, TRUE);     
   }
   }

   public function array_from_post($fields){
    $data = array();
    foreach ($fields as $field) {
      $data[$field] = $this->input->post($field);
    }     
    return $data;
   }
}

