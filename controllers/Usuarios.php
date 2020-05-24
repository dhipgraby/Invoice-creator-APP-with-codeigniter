<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios extends Buster_Controller
{

  function __construct()
  {
    parent::__construct();

    if ($this->data['user']->plan_id == 'SLIV_001' || $this->data['user']->plan_id == 'SLIV_004') {
      redirect('dashboard');
    }    
    $this->data['page_script'] = 'user/js/usuarios';
  }

  public function index()
  {
    $users = $this->user_m->get_all();
    $this->data['users'] = $users;
    $this->data['mainview'] = 'user/usuarios/index';
    $this->load->view('user/template/main_body', $this->data);
  }

  function send_request()
  {
    $data = array(
      'email' => $_POST['email'],
      'pages_priv' => $_POST['pages_priv'],
      'config_priv' => $_POST['config_priv']
    );
    
    if($this->_users_limit() == FALSE){
      echo alert_msg('Ha alcansado el limite de usuarios de su plan actual, para agregar mas usuarios cambie a un plan superior en <a href="'.base_url('subscription').'">Subscripción</a>', 'warning');
      return FALSE;
    }

    $rules = $this->user_m->_user_request;
    $this->form_validation->set_rules($rules);
    if ($this->form_validation->run() == FALSE) {
      echo alert_msg(validation_errors(), 'warning');
      return FALSE;
    }
    if ($this->_new_user_email($_POST['email']) == FALSE) {
      echo alert_msg('Este email esta en uso', 'warning');
      return FALSE;
    }
    if ($this->user_m->user_request($data) == FALSE) {
      echo alert_msg('Email incorrecto, introduzca un email valido', 'warning');
      return FALSE;
    }
    if ($this->user_m->_add_user_notification($_POST['email']) == FALSE) {
      echo alert_msg('Error al enviar el correo. Espere 1 minuto e intentelo nuevamete', 'warning');
      return FALSE;
    }
    $this->load->model('email_m');    
    //SENDING EMAIL WITH ACTIVATION CODE
    $code = $this->user_m->_get_current_code($_POST['email']);
    $this->data['first_msg'] = 'Ha sido invitado a participar como usuario de una cuenta de SlappInvoice';
    $this->data['second_msg'] = 'Para configurar sus credenciales de acceso a su cuenta use este link: <a href="' . base_url('add_user?code=' . $code->code) . '">' . base_url('add_user?code=' . $code->code) . '</a>';
    $this->data['third_msg'] = 'Si necesita asistencia, soporte o tiene alguna duda puede ponerse en contacto directo aquí: <a href="https://slappinvoice.com/soporte">Soporte</a>';
    $template =  $this->load->view('email/main_template', $this->data, TRUE);
    if($this->email_m->_add_user($_POST['email'], $template) == FALSE){
      echo alert_msg('Error al enviar el correo. Espere 1 minuto e intentelo nuevamete', 'warning');
      return FALSE;
    }
    //SETTING TIMER 30 secs FOR USER TO SEND EMAIL AGAIN
    $this->session->set_tempdata('user_request', TRUE, 30);
    echo alert_msg('Solicitud de usuario enviada.', 'success');
  }

  function editar($id)
  {
    $this->load->model('perfil_m');
    $rules = $this->perfil_m->_edit;
    $rules['password'] = null;
    $this->session->set_userdata('edit_user', $id);
    $this->form_validation->set_rules($rules);
    if ($this->form_validation->run() == TRUE) {
      $data = array(
        'firstname' => $_POST['firstname'],
        'email' => $_POST['user_email'],
      );

      if ($this->perfil_m->guardar($data, $id) == TRUE) {
        $message = alert_msg('Datos actualizados!', 'success');
        if ($id == $this->session->user_id) {
          $message .= "<script>$('#current_name').html('" . $data['firstname'] . "');</script>";
        }
        $json_data = array('msg' => $message, 'result' => 'success');
        echo json_encode($json_data);
      } else {
        $errors = 'No se han realizado cambios en los datos';
        $message = alert_msg($errors, 'info');
        $json_data = array('msg' => $message, 'result' => 'error');
        echo json_encode($json_data);
      }
    } else {
      $errors = validation_errors();
      $message = alert_msg($errors, 'warning');
      $json_data = array('msg' => $message, 'result' => 'error');
      echo json_encode($json_data);
    }
  }

  function change_password($id)
  {
    $this->load->model('perfil_m');
    $this->session->set_userdata('edit_user', $id);
    $rules = $this->user_m->_change_password;
    $this->form_validation->set_rules($rules);

    $password = $_POST['new_password'];
    if ($this->form_validation->run() == TRUE) {
      if ($this->perfil_m->change_password($password, $id) == TRUE) {

        $message = alert_msg('Contraseña cambiada!', 'success');
        $json_data = array('msg' => $message, 'result' => 'success');
        echo json_encode($json_data);
      } else {
        $errors = 'No se han realizado cambios en los datos';
        $message = alert_msg($errors, 'info');
        $json_data = array('msg' => $message, 'result' => 'error');
        echo json_encode($json_data);
      }
    } else {
      $errors = validation_errors();
      $message = alert_msg($errors, 'warning');
      $json_data = array('msg' => $message, 'result' => 'error');
      echo json_encode($json_data);
    }
  }

  function user_data($id)
  {
    $this->data['user_edit'] = $this->user_m->get_user($id);
    $this->load->view('user/modal/usuarios/edit_userdata', $this->data);
  }
  function user_table()
  {
    $this->data['users'] = $this->user_m->get_all();
    $this->load->view('user/usuarios/user_table', $this->data);
  }

  public function set_status()
  {
    $user_id = $_POST['id'];
    $value = $_POST['set_value'];
    if (empty($user_id)) {
      echo alert_msg('Usuario inválido', 'warning');
      return FALSE;
    }
    if ($this->user_m->set_status($user_id, $value) == FALSE) {
      echo alert_msg('No se ha realizado ningún cambio', 'warning');
      return FALSE;
    }
    echo alert_msg('Estatus de usuario actualizado', 'success');
    return TRUE;
  }

  function pages_priv($id)
  {
    $user = $this->user_m->get_user($id);
    $pages_priv = $this->input->post('pages_priv');
    if (empty($user)) {
      $errors = 'Error de usuario. Intente nuevamente';
      echo json_alert('error', 'warning', $errors);
      return FALSE;
    }
    if (empty($pages_priv)) {
      $errors = 'Error en los privilegios. Intente nuevamente';
      echo json_alert('error', 'warning', $errors);
      return FALSE;
    }
    if ($this->user_m->update_pages_priv($id, $pages_priv) == FALSE) {
      $errors = 'Error. Intente nuevamente';
      echo json_alert('error', 'warning', $errors);
      return FALSE;
    }
    $message = 'Permisos de páginas actualizados!';
    echo json_alert('error', 'success', $message);
    return TRUE;
  }
  function config_priv($id)
  {
    $user = $this->user_m->get_user($id);
    $config_priv = $this->input->post('config_priv');
    if (empty($user)) {
      $errors = 'Error de usuario. Intente nuevamente';
      echo json_alert('error', 'warning', $errors);
      return FALSE;
    }
    if (empty($config_priv)) {
      $errors = 'Error en los privilegios. Intente nuevamente';
      echo json_alert('error', 'warning', $errors);
      return FALSE;
    }
    if ($this->user_m->update_config_priv($id, $config_priv) == FALSE) {
      $errors = 'Error. Intente nuevamente';
      echo json_alert('error', 'warning', $errors);
      return FALSE;
    }
    $message = 'Permisos de páginas actualizados!';
    echo json_alert('error', 'success', $message);
    return TRUE;
  }

  function delete_user($id)
  {
    $user = $this->user_m->get_user($id);
    if (empty($user) || $user->owner == 1) {
      $errors = 'No se ha podido eliminar este usuario, intente nuevamente';
      $message = alert_msg($errors, 'warning');
      echo $message;
      return FALSE;
    }
    if ($user->user_id == $this->session->user_id) {
      $errors = 'Error. Esta intentando eliminar su propio usuario';
      $message = alert_msg($errors, 'warning');
      echo $message;
      return FALSE;
    }
    if ($this->user_m->delete_user($id) == FALSE) {
      $errors = 'No se ha podido eliminar este usuario, intente nuevamente';
      $message = alert_msg($errors, 'warning');
      echo $message;
      return FALSE;
    }
    $message = alert_msg('Usuario eliminado!', 'success');
    echo $message;
    return TRUE;
  }

  //RULES
  function _email_timer()
  {
    $this->load->model('email_m');
    return $this->email_m->_email_timer();
  }

  function _unique_name()
  {
    return $this->rules_m->_unique_name();
  }

  function _unique_email()
  {
    return $this->rules_m->_unique_email();
  }

  function _new_user_email($email)
  {
    $this->db->where('email', $email)
      ->where('firstname!=', NULL)
      ->where('password!=', NULL);
    $user = $this->db->get('users')->row();
    if (empty($user)) {
      return TRUE;
    }
    return FALSE;
  }

  function _unique_user_email()
  {
    return $this->rules_m->_unique_user_email();
  }

  function _user_password_check()
  {
    return $this->rules_m->_user_password_check();
  }

  function _users_limit(){
    return $this->user_m->_users_limit();
  }
}
