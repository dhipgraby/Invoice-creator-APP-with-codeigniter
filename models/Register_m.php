<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register_m extends MY_Model
{
    public $_register = array(

        'email' => array(
            'field' => 'email',
            'label' => 'email',
            'rules' => 'trim|valid_email|required'
        ),
    );

    public $_create = array(

        'email' => array(
            'field' => 'email',
            'label' => 'email',
            'rules' => 'trim|callback__unique_user_email|valid_email|required'
        ),

        'firstname' => array(
            'field' => 'firstname',
            'label' => 'Nombre de contacto',
            'rules' => 'required'
        ),

        'password' => array(
            'field' => 'password',
            'label' => 'Contraseña',
            'rules' => 'trim|required|callback__password_check|required|min_length[6]'
        ),

        'password_confirm' => array(
            'field' => 'password_confirm',
            'label' => 'Confirmar contraseña',
            'rules' => 'trim'
        ),
    );
    public $_add_user = array(

        'firstname' => array(
            'field' => 'firstname',
            'label' => 'Nombre de contacto',
            'rules' => 'required'
        ),

        'password' => array(
            'field' => 'password',
            'label' => 'Contraseña',
            'rules' => 'trim|required|callback__password_check|required|min_length[6]'
        ),

        'password_confirm' => array(
            'field' => 'password_confirm',
            'label' => 'Confirmar contraseña',
            'rules' => 'trim'
        ),
    );

    function __construct()
    {
        parent::__construct();
    }

    function new_user($data)
    {
        $data['user_id'] = $this->rand_user_code();    
        $this->db->set($data);
        if ($this->db->insert('users')) {
            //Log in user.
            $session_data = array(
                'user_email' => $data['email'],
                'plan_loggedin' => TRUE,
                'firstname' => $data['firstname'],
                'user_id' => $data['user_id'],
            );
            $this->session->set_userdata($session_data);
            return TRUE;
        }
        return FALSE;
    }

     function rand_user_code()
    {
        $u_code = randLetter() . mt_rand(10, 100) . randLetter() . mt_rand(1000, 99999) . randLetter();
        return $u_code;
    }

    function _check_subscription($email)
    {
        $account = $this->db->where('email', $email)->get('users')->row();
        if (empty($account)) {
            return FALSE;
        }
        if ($account->licencia == 000000) {
            return FALSE;
        }
        return TRUE;
    }

    function _check_account($email)
    {
        $account = $this->db->where('email', $email)->get('users')->row();
        if (empty($account)) {
            return FALSE;
        }
        return TRUE;
    }

    public function add_user($data){
       $email = $this->session->add_email;
       $this->db->where('email',$email)->where('firstname',NULL)->where('password',NULL);
       $user = $this->db->get('users')->row();
       if(empty($user)){
           return FALSE;
       }
       $current_code = $this->_get_current_code($email);
       $this->db->where('code',$current_code->code)->set('status',1)->update('email_notifications');       
       $this->db->where('user_id',$user->user_id)->set($data)->update('users');
       return ($this->db->affected_rows() < 1) ? FALSE : TRUE;        
    }

    public function _get_current_code($email)
    {
        $code = $this->db->where('email', $email)->where('type', 'add_user')->where('status',2)->get('email_notifications')->row();
        if (empty($code)) {
            return FALSE;
        }
        return $code;
    }

    public function _check_code($code)
    {
        $valid_code = $this->db->where('code', $code)->where('type','add_user')->where('status', 2)->get('email_notifications')->row();
        if (empty($valid_code)) {
            return FALSE;
        }
        $this->session->add_email = $valid_code->email;
        return TRUE;
    }
}
