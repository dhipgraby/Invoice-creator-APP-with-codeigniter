<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client_m extends MY_Model {

protected $_table_name = 'clientes';
protected $_order_by = '';

public $create_new = array(

  'nombre_cliente' =>array(
      'field' => 'nombre_cliente',
      'label' => '<b>nombre cliente</b>',
      'rules' =>'required|callback__unique_client_name'),  

  'cif' =>array(
      'field' => 'cif',
      'label' => '<b>CIF</b>',
      'rules' =>'callback__unique_cif|required'),  

  'cp_cliente' =>array(
    'field' => 'cp_cliente',
    'label' => '<b>cp_cliente</b>',
    'rules' =>'required'),  
      
  'direccion_cliente' =>array(
          'field' => 'direccion_cliente',
          'label' => 'direccion cliente',
          'rules' =>'required'),
      
  'provincia_cliente' =>array(
          'field' => 'provincia_cliente',
           'label' => 'provincia cliente', 
           'rules' => 'required'),  
      
  'poblacion_cliente' =>array(
          'field' => 'poblacion_cliente',
           'label' => 'poblacion cliente', 
           'rules' => 'required'),

  'telefono_cliente' =>array(
          'field' => 'telefono_cliente',
           'label' => 'telefono cliente', 
           'rules' => 'required'));

  public $p_contacto = array(

            'nombre' =>array(
                'field' => 'nombre',
                'label' => '<b>Nombre de contacto</b>',
                'rules' =>'required'),  
       );
          

	function __construct() {
      parent::__construct(); 

   }



   function guardar($id=null,$data){    

    if(!empty($data)){
        //UPDATE
      if($id != null && !empty($id)){

        $this->db2->where('id_cliente',$id)
        ->set($data)
        ->update('clientes');
        return ($this->db2->affected_rows() < 1) ? FALSE : TRUE;     
      } 
      //INSERT
      else { 
        $this->db2->set($data);    
        if ($this->db2->insert('clientes')) {    
            return TRUE;                   
            }
      }      
     return FALSE;
    }
    return FALSE;
}

function guardar_contacto($id=null,$data){
  if(!empty($data)){
    //UPDATE
  if($id != null && !empty($id)){

    $this->db2->where('id',$id)
    ->set($data)
    ->update('p_contacto');
    return ($this->db2->affected_rows() < 1) ? FALSE : TRUE;     
  } 
  //INSERT
  else { 
    $this->db2->set($data);    
    if ($this->db2->insert('p_contacto')) {    
        return TRUE;                   
        }
  }      
 return FALSE;
}
return FALSE;
}

function get_single($id){    
	  
    $client = $this->db2->where('id_cliente',$id)->where('id_cliente!=',0)->get('clientes')->row();  
    if(count($client)){
      return $client;
    }
    else {
      return FALSE;
    } 
  }

function get_all($filter=null,$page=null){     
    
    $perpage = 10;
    if ($page == null || $page < 1) {    
        $page=1;     
    }    
    $start_from = ($page-1) * $perpage;  
    $where = ' clientes.id_cliente != 0';    
        if(!empty($filter) && $filter != null){         
          $where = "clientes.nombre_cliente like '%".$filter."%'";
          $this->db2->where($where);
        }
    $clientes =  $this->db2->limit($perpage, $start_from)        
                     ->order_by('id_cliente', 'DESC')->where('id_cliente!=',1)          
                     ->get('clientes')
                     ->result_array();      
                     
    $result = $this->db2->where($where)->get('clientes')->num_rows();                       
    $clientes['count'] = $result;                     
                     return $clientes;
}

function get_clients($like){    
    if(!empty($like)){               
       $this->db2->like('nombre_cliente',$like);
    }
    $clients = $this->db2->limit(20)
                   ->get('clientes')->result_array();
                   $return_arr = array();

                   foreach($clients as $client){
                    $id_cliente=$client['id_cliente'];
                    $row_array['value'] = $client['nombre_cliente'];
                    $row_array['id_cliente']=$id_cliente;
                    $row_array['nombre_cliente']=$client['nombre_cliente'];
                    $row_array['telefono_cliente']=$client['telefono_cliente'];
                    $row_array['email_cliente']=$client['email_cliente'];
                    array_push($return_arr,$row_array);
                   }                
                   return $return_arr;
                }

function get_contactos($id,$page){
  
  $perpage = 3;
  if ($page == null || $page < 1) {
  $page=1;   
  }  
  $start_from = ($page-1) * $perpage;  
  $contactos = $this->db2->where('client_id',$id)
                         ->limit($perpage, $start_from)                       
                         ->get('p_contacto')
                         ->result();
   $results =  $this->db2->where('client_id',$id)
                         ->get('p_contacto')
                         ->result();   
                       $contactos['count'] = count($results);    
                       return $contactos;
}
 
function get_docs($type, $filter = null, $page = null)
{
  if ($type == null) {
    return FALSE;
  }
  $perpage = 10;
  $year = date('Y');
  $year_limit = date('Y', strtotime('+1 years'));

  if ($filter['fecha'] != null) {
    $year = $filter['fecha'];
    $year_limit = intval($year + 1);
  }

  if ($page == null || $page < 1) {
    $page = 1;
  }

  $start_from = ($page - 1) * $perpage;

  //FILTRADO POR FECHA Y TIPO
  $where = 'facturas.id_cliente=clientes.id_cliente
                and facturas.documento="' . $type . '" and
                year(facturas.fecha_factura) >= "' . $year . '" and
                year(facturas.fecha_factura) < "' . $year_limit . '" ';
  //FILTRADO POR ESTADO DE DOCUMENTO    
  if ($filter['estado'] != 0) {
    $where .= ' and facturas.estado_factura =' . $filter['estado'];
  }
  //FILTRADO POR ID DE CLIENTE 
  $where .= " and clientes.id_cliente=" . $filter['id_cliente'] . " ";

  $total_docs =  $this->db2->where($where)->get('facturas,clientes')->num_rows();
  $docs =  $this->db2->where($where)
    ->limit($perpage, $start_from)
    ->order_by('facturas.id_factura', 'DESC')
    ->get('facturas,clientes')
    ->result_array();
  
    $docs['count'] = $total_docs;
  
  return $docs;
}

function fiscal_year($id_cliente){  
  $años = $this->db2
     ->where('id_cliente', $id_cliente)
    ->group_by('year(fecha_factura)')
    ->order_by('fecha_factura', 'desc')
    ->get('facturas')->result();
  return $años;
}

function cliente_a_factura($client_id,$id_factura){

  $this->db2->where('id_factura',$id_factura)
            ->set('id_cliente',$client_id)
            ->update('facturas');

}

function last_id(){                    
     $last_id = $this->db2->select_max('id_cliente')
                          ->get('clientes')->row();
                       return $last_id->id_cliente;              
                }

function eliminar_cliente($id){

  $factura = $this->db2->where('id_cliente',$id)->get('facturas')->result();
    if(!count($factura)){
        $this->db2->where('id_cliente',$id)->delete('clientes');
        return ($this->db2->affected_rows() < 1) ? FALSE : TRUE;
    }   
 return FALSE;
  }

  function eliminar_contacto($id){
    
          $this->db2->where('id',$id)->delete('p_contacto');
          return ($this->db2->affected_rows() < 1) ? FALSE : TRUE;      
   
    }

}