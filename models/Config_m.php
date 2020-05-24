<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Config_m extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }
   //IF NO USER ADMIN, INSERT THE OWNER
    function get_admin($id)
    {
        $user = $this->db->where('user_id', $id)->get('users')->row();
        if (empty($user)) {
            $first_user = array(
                'user_id' => $id,
                'firstname' => $this->session->firstname,                
                'datecreate' => date('Y-m-d h:i'),
                'pages_priv' => 222,
                'config_priv' => 222,
            );
            $this->db->insert('users', $first_user);
        }
    }
    //CONFIGURACION DE DOCUMENTOS GENERAL
    function doc_config()
    {
        $doc_config = $this->db2->limit(1)->get('configuracion')->row();
        return $doc_config;
    }

    //CONFIGURACION DE PAGOS
    function payment_config()
    {
        $payment_config = $this->db2->limit(1)->get('payment_conf')->row();
        return $payment_config;
    }

    //UNIDADES DE PRODUCTOS
    public function products_unit($config_num){
       if(empty($config_num)){
           return FALSE;
       }   
       $this->db2->set('unidades',$config_num);
       if(!$this->db2->update('configuracion')){
           return FALSE;
       }
       return TRUE;
    }
 
    //DOCUMENTS OPTIONS
    function set_option($name, $value)
    {
        if (empty($name)) {
            return FALSE;
        }
        $this->db2->set($name, $value)->update('configuracion');
        return ($this->db2->affected_rows() < 1) ? FALSE : TRUE;
    }
    //OPCIONES PARA METODOS DE PAGOS  
    function set_payment_option($name, $value)
    {
        if (empty($name)) {
            return FALSE;
        }
        $this->db2->set($name, $value)->update('payment_conf');
        return ($this->db2->affected_rows() < 1) ? FALSE : TRUE;
    }

    function set_text($name, $content)
    {
        if (empty($name)) {
            return FALSE;
        }
        $this->db2->set($name, $content)->update('configuracion');
        return ($this->db2->affected_rows() < 1) ? FALSE : TRUE;
    }   
}
