<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_m extends MY_Model {

protected $_table_name = 'perfil';
protected $_table_col = '';

public $_update = array(

    'nombre_empresa' =>array(
        'field' => 'nombre_empresa',
        'label' => '<b>Nombre empresa</b>',
        'rules' =>'required'),  
  
    'direccion' =>array(
            'field' => 'direccion',
            'label' => 'direccion',
            'rules' =>'required'),
    'cif' =>array(
        'field' => 'cif',
        'label' => 'CIF',
        'rules' =>'required'),
     
    'email' =>array(
                'field' => 'email',
                'label' => 'email',
                'rules' =>'required'),
                    
    'provincia' =>array(
            'field' => 'provincia',
             'label' => 'provincia', 
             'rules' => 'required'),  
        
    'poblacion' =>array(
            'field' => 'poblacion',
             'label' => 'poblacion', 
             'rules' => 'required'),
    
    'codigo_postal' =>array(
            'field' => 'codigo_postal',
             'label' => 'codigo postal', 
             'rules' => 'required'),         
  
    'telefono' =>array(
            'field' => 'telefono',
             'label' => 'telefono', 
             'rules' => 'required'));
  
	function __construct() {
      parent::__construct(); 

    }

   function get_perfil(){    

    $perfil = $this->db2->limit(1)->get($this->_table_name)->row();  
    return $perfil; 
   }

   function guardar($data){         
  
  $perfil = $this->db2->limit(1)->get($this->_table_name)->row();        
     if(count($perfil) && !empty($data)){
        $this->db2->set($data)
        ->update('perfil');
        return ($this->db2->affected_rows() < 1) ? FALSE : TRUE;
     }
      return FALSE;
   }

   function guardar_logo($nombre_imagen){
      
    $logo = $nombre_imagen;
    if(!empty($logo)){
        $this->db2->set('logo_url',$logo)
                  ->update('perfil');
return ($this->db2->affected_rows() < 1) ? FALSE : TRUE;                
    }
    return FALSE;
   }

}