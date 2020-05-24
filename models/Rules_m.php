<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rules_m extends MY_Model
{

  protected $_table_name = 'members';
  protected $_table_col = 'deposits';
  protected $_order_by = 'datetime desc';
  protected $_timestamps = TRUE;



  function __construct()
  {
    parent::__construct();
  }
  //FUNCION PARA EL PERFIL

  function _unique_client_name()
  {
    $id = $this->session->edit_user;
    if ($id > 0) {
      $this->db2->where('id_cliente!=', $id);
    }
    $this->db2->where('nombre_cliente', $this->input->post('nombre_cliente'));
    $user = $this->db2->get('clientes')->result();
    if (count($user)) {
      $this->form_validation->set_message('_unique_client_name', 'Nombre de cliente existente.');
      return FALSE;
    }
    return TRUE;
  }

  function _unique_cif()
  {

    $cif = $this->input->post('cif');
    if (!empty($cif) || $cif != '') {
      $id = $this->session->edit_user;
      if ($id > 0) {
        $this->db2->where('id_cliente!=', $id);
      }
      $this->db2->where('cif', $cif);
      $cif_exist = $this->db2->get('clientes')->result();
      if (count($cif_exist)) {
        $this->form_validation->set_message('_unique_cif', 'Cif de cliente existente.');
        return FALSE;
      }
    }
    return TRUE;
  }
//USER FUNCTIONS
  
  function _valid_status(){
    $this->db->where('email', $this->input->post('email'));
    $user = $this->db->get('users')->row();
    if ($user->status != 1) {
      $this->form_validation->set_message('_valid_status', 'Usuario inactivo, contacte con el administrador de su cuenta');
      return FALSE;
    }
    return TRUE;
  }

  function _unique_email()
  {
    $id = $this->session->edit_user;
    $this->db->where('user_email', $this->input->post('user_email'));
    $this->db->where('user_id !=', $id);
    $user = $this->db->get('users')->row();
    if (!empty($user)) {
      $this->form_validation->set_message('_unique_email', 'Este email esta en uso');
      return FALSE;
    }
    return TRUE;
  }

  function _unique_user_email()
  {

    $this->db->where('email', $this->input->post('email'));
    $user = $this->db->get('users')->result();
    if (!empty($user)) {
      $this->form_validation->set_message('_unique_user_email', 'Este email esta en uso');
      return FALSE;
    }
    return TRUE;
  }

  function _password_check()
  {
    $new_password =  $this->input->post('password');
    $password_confirm = $this->input->post('password_confirm');
    if ($new_password != $password_confirm) {
      $this->form_validation->set_message('_password_check', 'Las contraseñas no coinciden');
      return FALSE;
    }
    return TRUE;
  }

  function _user_password_check()
  {
    $new_password =  $this->input->post('new_password');
    $password_confirm = $this->input->post('new_password_confirm');
    if ($new_password != $password_confirm) {
      $this->form_validation->set_message('_user_password_check', 'Las contraseñas no coinciden');
      return FALSE;
    }
    return TRUE;
  }

  function _perfil_password_check()
  {

    $new_password =  $this->input->post('new_password');
    $password_confirm = $this->input->post('password_confirm');
    if ($new_password != $password_confirm) {
      $this->form_validation->set_message('_perfil_password_check', 'Las contraseñas no coinciden');
      return FALSE;
    }
    return TRUE;
  }



  function _old_password_check()
  {
    $recovery_email = $this->session->recovery_email;
    $password = $this->input->post('password');
    $this->db->where('password', hash('sha256', $password . config_item('encryption_key')))->where('email', $recovery_email);
    $user = $this->db->get('users')->row();
    if (!empty($user)) {
      $this->form_validation->set_message('_old_password_check', 'Esta contraseña es inválida. Intente con otra');
      return FALSE;
    }
    return TRUE;
  }

  function _password_validation()
  {

    $password = $this->input->post('password');
    $this->db->where('password', hash('sha256', $password . config_item('encryption_key')))->where('user_id', $this->session->user_id);
    $user = $this->db->get('users')->row();
    if (empty($user)) {
      $this->form_validation->set_message('_password_validation', 'Contraseña incorrecta');
      return FALSE;
    }
    return TRUE;
  }
//PAYMENT FUNCTIONS
  function _unique_edit_banc()
  {

    $id = $this->session->cuenta;
    $this->db2->where('cuenta', $this->input->post('cuenta'));
    $this->db2->where('id !=', $id);
    $banco = $this->db2->get('bancos')->row();
    if (!empty($banco)) {
      $this->form_validation->set_message('_unique_edit_banc', 'Este número de cuenta esta en uso');
      return FALSE;
    }
    return TRUE;
  }

  function _unique_banc()
  {

    $this->db2->where('cuenta', $this->input->post('cuenta'));
    $banco = $this->db2->get('bancos')->row();
    if (!empty($banco)) {
      $this->form_validation->set_message('_unique_banc', 'Este número de cuenta esta en uso');
      return FALSE;
    }
    return TRUE;
  }


  function _unique_edit_paypal()
  {

    $id = $this->session->paypal;

    $this->db2->where('email', $this->input->post('email'));
    $this->db2->where('id !=', $id);
    $paypal = $this->db2->get('paypal')->row();
    if (!empty($paypal)) {
      $this->form_validation->set_message('_unique_edit_paypal', 'Este email esta en uso');
      return FALSE;
    }
    return TRUE;
  }

  function _unique_paypal()
  {

    $this->db2->where('email', $this->input->post('email'));
    $paypal = $this->db2->get('paypal')->row();
    if (!empty($paypal)) {
      $this->form_validation->set_message('_unique_paypal', 'Este email esta en uso');
      return FALSE;
    }
    return TRUE;
  }
}
