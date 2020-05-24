<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perfil_m extends MY_Model
{
    protected $_order_by = '';
    protected $_timestamps = TRUE;
    public $_edit = array(
        'firstname' => array(
            'field' => 'firstname',
            'label' => 'Nombre',
            'rules' => 'trim|required'
        ),
        'password' => array(
            'field' => 'password',
            'label' => 'Contraseña',
            'rules' => 'trim|required|callback__password_validation'
        ),
    );

    public $_password_val = array(

        'password_check' => array(
            'field' => 'password',
            'label' => 'Contraseña',
            'rules' => 'trim|required|callback__password_validation'
        ),

        'new_password' => array(
            'field' => 'new_password',
            'label' => 'Nueva contraseña',
            'rules' => 'trim|required|callback__perfil_password_check|min_length[6]'
        ),

        'password_confirm' => array(
            'field' => 'password_confirm',
            'label' => 'Confirmar contraseña',
            'rules' => 'required|trim'
        ),
    );

    function __construct()
    {
        parent::__construct();
    }

    function get_user($id)
    {
        $user = $this->db->where('user_id', $id)->get('users')->row();
        if (count($user)) {
            return $user;
        }
    }

    function guardar($data, $id)
    {
        $this->db->where('user_id', $id)->set($data)->update('users');                    
        return ($this->db->affected_rows() < 1) ? FALSE : TRUE;        
    }

    function change_password($password, $id)
    {
        if (!empty($password)) {
            $this->db->where('user_id', $id)->set('password', hash('sha256', $password . config_item('encryption_key')))->update('users');
            return ($this->db->affected_rows() < 1) ? FALSE : TRUE;
        }
    }
}
