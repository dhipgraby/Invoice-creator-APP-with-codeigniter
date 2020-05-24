<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends Frontend_Controller
{
  public function index()
  {
    if (isset($this->session->register_email)) {
      $this->data['email'] = $this->session->register_email;
    }
    if (isset($_COOKIE['user_mail'])) {
      $this->data['email'] = $_COOKIE['user_mail'];
    }

    $this->data['mainview'] = 'user/index';
    $this->load->view('user/main_body', $this->data);
  }

  public function login()
  {
    $rules = $this->login_m->login_rules;
    $this->form_validation->set_rules($rules);
    //Process the from
    if ($this->form_validation->run() == TRUE) {

      $this->_login_proof();
    } else {

      $errors = validation_errors();
      $data = array(
        'log' => 'error',
        'view' => alert_msg($errors, 'warning'),
      );
      echo json_encode($data);
    }
  }

  function _login_proof()
  {    
    if ($this->login_m->login() == TRUE) {
      $script  = '<script>          
                setTimeout(function(){ 
                  location.reload("dashboard");
                }, 2000);
                </script>';
      if($this->session->active_user == FALSE)
      {
        $data = array(
          'log' => 'error',
          'view' =>  alert_msg('Usuario inactivo, contacte con el administrador de su cuenta', 'warning'),
        );
        echo json_encode($data);
        return FALSE;  
      }          
      $data = array(
        'log' => 'success',
        'view' =>  alert_msg(' Datos Correctos! Redirigiendo al dashboard...', 'success') . $script,
      );
      echo json_encode($data);
    } else {
      $data = array(
        'log' => 'error',
        'view' => alert_msg('Algún dato es incorrecto', 'warning'),
      );
      echo json_encode($data);
    }
  }
}
