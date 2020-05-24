<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_m extends MY_Model
{

    public $login_rules = array(

        'email' => array(
            'field' => 'email',
            'label' => '<b>Email</b>',
            'rules' => 'trim|required|xss_clean'
        ),

        'password' => array(
            'field' => 'password',
            'label' => 'password',
            'rules' => 'trim|required|min_length[6]'
        ),
    );

    function __construct()
    {
        parent::__construct();
    }

    //REMEMBER TO PASS THE IP TO LOGIN
    public function login()
    {
        $email = $this->input->post('email');        
        $password = $this->input->post('password');      
        //SELECTING USER PASS
        $this->db->where('email',$email);
        $this->db->where('password', hash('sha256', $password . config_item('encryption_key')));
        $user = $this->db->get('users')->row();
        if (empty($user)) {
            return FALSE;
        }
        
        $is_owner = ($user->owner == 1) ? TRUE : FALSE; 
        setcookie('user_mail',$user->email,time() + (86400 * 30)); 
        //SETTING USERDATA.
        $data = array(
            'active_user' => ($user->status != 1) ? FALSE :TRUE,
            'licencia' => $user->licencia,
            'firstname' => $user->firstname,
            'email' => $user->email,
            'is_owner' => $is_owner,
            'user_id' => $user->user_id,
            'loggedin' => ($user->status != 1) ? FALSE :TRUE,
        );     
        $this->session->set_userdata($data);
        return TRUE;
    }

    public function logout()
    {      
        session_destroy();
    }

    public function loggedin()
    {
        return (bool) $this->session->userdata('loggedin');
    }

    public function plan_loggedin()
    {
        return (bool) $this->session->userdata('plan_loggedin');
    }

    public function is_owner()
    {
        return (bool) $this->session->userdata('is_owner');
    }


}
