<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Buster_controller extends MY_Controller
{

  function __construct()
  {
    parent::__construct();

    if (empty($this->session->user_id)) {
      $this->login_m->logout();
      redirect('main');
    }
    $licencia = $this->session->licencia;
    //IF USER HAVE NOT DB ASIGN
    if ($licencia == 000000) {
      if ($this->login_m->plan_loggedin() == FALSE) {
        $data = array(
          'user_email' => $this->session->email,
          'plan_loggedin' => TRUE,
        );
        $this->session->set_userdata($data);
      }
      $this->session->loggedin = FALSE;
      redirect('register/plan_subscription');
    }
    //LOAD DB
    if (!empty($licencia)) {
      $config_app = switch_db_dinamico($licencia);
      $this->db2 = $this->load->database($config_app, TRUE);
    }
    $this->load->model('config_m');
    $this->load->model('user_m');
    $this->load->model('subscription_m');
    //CREATE A ADMIN USER IF NOT EXIST
    if ($this->login_m->is_owner() == TRUE) {
      $this->config_m->get_admin($this->session->user_id);
    }
    //CHECK SUBSCRIPTION STATUS
    $this->current_subscription = $this->subscription_m->get_subscription();
    if ($this->current_subscription->status == 'canceled') {
      $this->data['sub_canceled'] = TRUE;
      $subscription_uris = array(
        'logout',
        'subscription',
        'subscription/update',
        'subscription/update/config_init',
        'subscription/update/checkout',
        'subscription/update/create_session',
        'subscription/update/checkout_session',
        'subscription/update/success',
        'subscription/update/cancel',
      );
      if (in_array(uri_string(), $subscription_uris) == FALSE) {
        redirect('subscription');
      }
    }
    $user = $this->user_m->get_user($this->session->user_id);
    $this->data['user'] = $user;
    $pages_access = str_split($user->pages_priv);
    $config_access = str_split($user->config_priv);
    $this->data['licencia'] = $licencia;
    $this->data['simbolo_moneda'] = '€';
    $this->data['acc_config'] = $this->config_m->doc_config();
    $this->data['payment_config'] = $this->config_m->payment_config();
    $this->data['pages_access'] = $pages_access;
    $this->data['config_access'] = $config_access;
    //URI ACCESS CONFIG
    $pages_uris = array(
      'facturas' => $pages_access[0],
      'proformas' => $pages_access[0],
      'abonos'  => $pages_access[0],
      'presupuestos' => $pages_access[1],
      'clientes' => $pages_access[2],
    );

    $access_uris = array(
      'facturas',
      'presupuestos',
      'proformas',
      'abonos',
      'clientes',
    );

    $config_uris = array(
      'cuenta' => $config_access[0],
      'usuarios' => $config_access[1],
    );

    $config_access_uris = array(
      'cuenta',
      'usuarios',
    );
    //ACCESS TO PAGES
    if (in_array(uri_string(), $access_uris) == TRUE) {

      if ($pages_uris[uri_string()] == 3) {
        redirect('dashboard');
      }
    }
    //ACCESS TO CONFIG
    if (in_array(uri_string(), $config_access_uris) == TRUE) {
      if ($config_uris[uri_string()] == 3) {
        redirect('dashboard');
      }
    }
  }
}
