<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perfil extends Buster_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->data['page_script'] = 'user/js/perfil';
        $this->load->model('perfil_m');
    }


    public function index()
    {                
        $this->data['mainview'] = 'user/perfil/index';
        $this->load->view('user/template/main_body', $this->data);
    }

    function editar()
    {
        $rules = $this->perfil_m->_edit;
        $id = $this->session->user_id;
        $this->session->set_userdata('edit_user', $id);
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'firstname' => $_POST['firstname'],
                'email' => $_POST['email'],
            );

            if ($this->perfil_m->guardar($data, $id) == TRUE) {
                $r_script = "<script>$('#current_name').html('".$data['firstname']."');</script>";
                $message = alert_msg('Datos actualizados!', 'success').$r_script;
                echo $message;
            } else {
                $errors = 'No se han realizado cambios en los datos';
                echo alert_msg($errors, 'info');
            }
        } else {
            $errors = validation_errors();
            echo alert_msg($errors, 'warning');
        }
    }

    function change_password()
    {
        $id = $this->session->user_id;
        $this->session->set_userdata('edit_user', $id);
        $rules = $this->perfil_m->_password_val;
        $this->form_validation->set_rules($rules);        
        $new_password = $_POST['new_password'];
        if ($this->form_validation->run() == TRUE) {
            if ($this->perfil_m->change_password($new_password, $id) == TRUE) {      
                $message = alert_msg('Contraseña cambiada!', 'success');
                echo $message;
            } else {
                $errors = 'No se han realizado cambios en los datos';
                echo alert_msg($errors, 'info');
            }
        } else {
            $errors = validation_errors();
            echo alert_msg($errors, 'warning');
        }
    }


    //RULES

    function _unique_name()
    {
        return $this->rules_m->_unique_name();
    }

    function _unique_email()
    {
        return $this->rules_m->_unique_email();
    }

    function _perfil_password_check()
    {
        return $this->rules_m->_perfil_password_check();
    }

    function _password_validation()
    {
        return $this->rules_m->_password_validation();
    }
}
