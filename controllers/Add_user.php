<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Add_user extends Frontend_Controller
{
    function __construct()
    {
        parent::__construct();        
        $this->load->model('register_m');        
    }

    public function index()
    {
        $code = $_GET['code'];
        if (empty($code)) {
            redirect('main');
            return FALSE;
        }
        if ($this->register_m->_check_code($code) == FALSE) {
            $this->data['mainview'] = 'register/invalid_code';
        } else {            
            $this->data['mainview'] = 'register/add_user';
        }                
        $this->load->view('user/main_body', $this->data);
    }
   

    public function set_user()
    {
        $email = $this->session->add_email;
        if(empty($email)){
            echo json_alert('error','warning','Código expirado o email inválido, solicite otro código para validar su cuenta');
            return FALSE; 
        }
        $rules = $this->register_m->_add_user;
        $this->form_validation->set_rules($rules);
        //Process the from
        if($this->form_validation->run() == FALSE) {                    
            echo json_alert('error','warning',validation_errors());
            return FALSE;
        }
        $data = array(
            'firstname' => $_POST['firstname'],
            'password' => hash('sha256', $_POST['password']. config_item('encryption_key')),    
            'owner' => 0,  
            'status' => 1,
        );

        if($this->register_m->add_user($data) == FALSE){
            echo json_alert('error','warning','Error en los campos, verifique su información e intente nuevamente');
            return FALSE;
        } 
        echo json_alert('success','success','Cambio de contraseña exitoso!');
        return TRUE;
    }

    //RULES
    function _password_check()
    {
        $this->load->model('rules_m');
        return $this->rules_m->_password_check();
    }

    function _email_timer()
    {
        $this->load->model('email_m');
        return $this->email_m->_email_timer();
    }
}
