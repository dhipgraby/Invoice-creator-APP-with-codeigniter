<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Recover_m extends MY_Model
{
    public $_email = array(

        'email' => array(
            'field' => 'email',
            'label' => 'email',
            'rules' => 'trim|valid_email|required|callback__email_timer'
        ),
    );

    public $_set_password = array(

        'password' => array(
            'field' => 'password',
            'label' => 'Contraseña',
            'rules' => 'trim|required|callback__password_check|callback__old_password_check|required|min_length[6]'
        ),

        'password_confirm' => array(
            'field' => 'password_confirm',
            'label' => 'Confirmar contraseña',
            'rules' => 'trim|required'
        ),
    );

    function __construct()
    {
        parent::__construct();
    }

    function _password_recover($email,$user)
    {   
        if (empty($user)) {
            return FALSE;
        }

        $current_code = $this->_get_current_code($email);
        if (!empty($current_code)) {
            return TRUE;
        }
        $code = $this->_recovery_code();
        $data = array(
            'type' => 'recovery',
            'email' => $user->email,
            'code' => $code,
            'datetime' => time(),
            'status' => 2
        );
        $this->db->set($data);
        if (!$this->db->insert('email_notifications')) {
            log_message('error', 'inserting recovery code to :' . $_POST['email']);
            return FALSE;
        }
        return TRUE;
    }

    public function _set_password($email, $new_password)
    {
        $current_code = $this->_get_current_code($email);
        $user = $this->db->where('email', $email)->get('users')->row();
        if (empty($user)) {
            return FALSE;
        }
        $this->db->where('code',$current_code->code)->set('status',1)->update('email_notifications');
        if($this->db->affected_rows() < 1){
            return FALSE;  
        }
        $this->load->model('user_m');
        return $this->user_m->change_password($new_password, $user->user_id);       
    }

    public function _check_code($code)
    {
        $valid_code = $this->db->where('code', $code)->where('type','recovery')->where('status', 2)->get('email_notifications')->row();
        if (empty($valid_code)) {
            return FALSE;
        }
        $this->session->recovery_email = $valid_code->email;
        return TRUE;
    }

    public function _cancel_code($email){
     $code = $this->_get_current_code($email);
     if(empty($code) || $code == FALSE){
         return TRUE;
     }
     $this->db->where('email', $email)->where('type', 'recovery')->where('status',2)->delete('email_notifications');
     return TRUE;
    }

    public function _get_current_code($email)
    {
        $code = $this->db->where('email', $email)->where('type', 'recovery')->where('status',2)->get('email_notifications')->row();
        if (empty($code)) {
            return FALSE;
        }
        return $code;
    }

    //UNIQUE CODE FOR EMAIL
    public function _recovery_code()
    {
        $mail_code =  mt_rand(10, 100) . randLetter() . randLetter() . mt_rand(1000, 99999) . randLetter();
        return $mail_code;
    }
}
