<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	function __construct() {
      parent::__construct(); 

      $this->data['site_name'] = config_item('site_name');  

      $this->load->helper('form');
      $this->load->library('form_validation');
      $this->load->library('session');
      $this->load->model('login_m');
      $this->load->model('rules_m');

      $exeption_uris = array(
            'logout',
            'register',
            'register/process',
            'register/plan_subscription',         
            'register/email_check',
            'register/nuevo',
            'register/success',
            'subscription/stripe/checkout_session',
            'subscription/stripe/create_session',
            'subscription/stripe/checkout',
            'subscription/stripe/config_init',
            'add_user',
            'add_user/set_user',           
            'password_reset',
            'password_reset/reset',
            'password_reset/new_password',        
            'password_reset/set_password',    
            'password_reset/cancel_code',    
            'main',
            'main/login',
            'main/test',
            'login',
          );
      
         // REDIRIGE AL USUARIO NO LOGEADO A LOGEARSE SI ACCEDE A OTRA RUTA QUE NO SEA $exeption_uris
          if (in_array(uri_string(), $exeption_uris) == FALSE) {      
            if ($this->login_m->loggedin() == FALSE) {      
              redirect('main');
            }
          }
      
      }

   }

