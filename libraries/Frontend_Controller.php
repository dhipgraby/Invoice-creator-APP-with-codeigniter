<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Frontend_controller extends MY_Controller
{

  function __construct()
  {
    parent::__construct();

    $this->data['meta_title'] = config_item('site_name');
    //redirect user if already log in
    $this->login_m->loggedin() == FALSE || redirect('dashboard');
  }
}
