<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register  extends Frontend_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('register_m');
  }

  public function index()
  {
    if(isset($_GET['plan'])){
      if(in_array(strtoupper($_GET['plan']),config_item('plan_type'))){
        $this->session->preselected_plan = strtoupper($_GET['plan']);
      }
    }
    unset($_SESSION['register_email']);
    $this->data['mainview'] = 'register/landing';
    $this->load->view('user/main_body', $this->data);
  }
  //PRIMER REGISTRO DE USUARIO SOLO CON CONTRASEÑA
  public function process()
  {
    if (empty($this->session->register_email) || $this->_check_account($this->session->register_email) == TRUE) {
      redirect('register');
    }
    $this->data['email'] = $this->session->register_email;
    $this->data['process_view'] = 'register/user_form';
    $this->data['mainview'] = 'register/process';
    $this->load->view('user/main_body', $this->data);
  }
  //PROCESO DE SELECCION DE PLANES Y METODO DE PAGO
  public function plan_subscription()
  {

    if (isset($_GET['canceled'])) {      
      $this->data['canceled'] = alert_msg('Orden cancelada, intentelo nuevamente', 'warning');
    }
    $this->login_m->plan_loggedin() == TRUE || redirect('register');

    if (empty($this->session->user_email)) {
      redirect('register');
      return FALSE;
    }
    if(!empty($this->session->preselected_plan)){
      $this->data['preselected_plan'] = $this->session->preselected_plan;
     }
    $this->data['stripe_js'] = TRUE;
    $this->data['process_view'] = 'register/plan_selection';
    $this->data['mainview'] = 'register/process';
    $this->load->view('user/main_body', $this->data);
  }
  //VISTA CUANDO EL TERMINA EL PROCESO DE PAGO. CARGA CHECKOUT DE STRIPE PARA CONFIGURAR LA CUENTA
  function success()
  {
    unset($_SESSION['plan_loggedin']);
    $this->data['process_view'] = 'register/success';
    $this->data['mainview'] = 'register/process';
    $this->load->view('user/main_body', $this->data);
  }

  //DEPENDE DEL EMAIL EXISTENTE O ONO, REDIRIGE A REGISTRO O LOGIN
  public function email_check()
  {
    $rules = $this->register_m->_register;
    $this->form_validation->set_rules($rules);
    if ($this->form_validation->run() == FALSE) {
      echo alert_msg(validation_errors(), 'warning');
      return FALSE;
    }
    $this->session->register_email = $_POST['email'];
    if ($this->_check_account($_POST['email']) == TRUE) {
      $script = '<script> setTimeout(function(){ go_to("main"); }, 3000); </script>';
      echo alert_msg('Ya existe una cuenta con este email. Redirigiendo a Login...', 'info') . $script;
      return FALSE;
    }
    $script = '<script> setTimeout(function(){ go_to("register/process"); }, 1500); </script>';
    echo alert_msg('Bienvenido! Redirigiendo creación de cuenta...', 'success') . $script;
    return TRUE;
    
  }

  //CREA NUEVO USUARIO Y REDIRIGE A PLAN_SUBCRIPTION
  function nuevo()
  {
    if (empty($this->session->register_email)) {
      redirect('register');
      return FALSE;
    }
    $action = $this->input->post('action');
    if (empty($action) || $action != 'submit') {
      redirect('register');
      return FALSE;
    }
    $rules = $this->register_m->_create;
    $this->form_validation->set_rules($rules);
    if ($this->form_validation->run() == FALSE) {      
      $message = alert_msg(validation_errors(), 'warning');
      $json_data = array('msg' => $message, 'result' => 'error');
      echo json_encode($json_data);
      return FALSE;
    }
    $data = array(
      'firstname' => $_POST['firstname'],
      'email' => $_POST['email'],
      'datecreate' =>  date("Y-m-d H:i:s"),
      'owner' => 1,
      'password' => hash('sha256', $_POST['password'] . config_item('encryption_key')),
      'pages_priv' => 222,
      'config_priv' => 222,
      'status' => 1,
    );    
    if ($this->register_m->new_user($data) == FALSE) {      
      $message = alert_msg('Error en los campos verifica la información', 'warning');
      $json_data = array('msg' => $message, 'result' => 'error');
      echo json_encode($json_data);
      return FALSE;
    }
    unset($_SESSION['register_email']);
    $message = alert_msg('Cuenta creada!', 'success');
    $json_data = array('msg' => $message, 'result' => 'success');
    echo json_encode($json_data);
  }


  //RULES
  function _password_check()
  {
    return $this->rules_m->_password_check();
  }

  function _unique_user_email()
  {
    return $this->rules_m->_unique_user_email();
  }

  function _check_subscription($email)
  {
    return $this->register_m->_check_subscription($email);
  }

  function _check_account($email)
  {
    return $this->register_m->_check_account($email);
  }
}
