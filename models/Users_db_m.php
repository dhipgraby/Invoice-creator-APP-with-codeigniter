<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users_db_m extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function asign_db($user_id)
    {
        if($this->check_user_db($user_id) == TRUE){            
            return FALSE;
        }
        $available_db = $this->available_db();
        if($available_db == FALSE || empty($available_db)){            
            return FALSE;
        }
      
        $user_array = array('licencia' =>$available_db->db_id,'plan_id' => $this->session->plan_id);
        //DATABASE 
        $data = array(
            'status' => 'active',
            'owner' => $user_id,
        );                
        //UPDATING USER DB "LICENCIA"
        $this->db->where('user_id', $user_id)->set($user_array)->update('users');
        //CHANGING DB STATUS OPEN TO ACTIVE
        $this->db->where('db_id', $available_db->db_id)->set($data)->update('users_db');        
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    function available_db(){
        $available_db = $this->db->where('status', 'open')->limit(1)->get('users_db')->row();
        if (empty($available_db)) {
            log_message('error','no hay bases de datos disponibles para asignar');                    
            return FALSE;
        }
        return $available_db;
    }

    function check_user_db($user_id)
    {
        $user_db = $this->db->where('owner', $user_id)->get('users_db')->row();
        if (empty($user_db)) {
            log_message('error','Cliente con id: '.$user_id.', ya tiene una base de datos asignada');        
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
