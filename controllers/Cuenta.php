<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cuenta extends Buster_Controller
{

  function __construct()
  {
    parent::__construct();

    $this->load->model('account_m');
    $this->data['page_script'] = 'user/js/cuenta';
  }

  public function index()
  {
    $this->load->model('payment_m');
    $perfil = $this->account_m->get_perfil();
    $payments = $this->payment_m->get_methods();
    $this->data['product_config'] = str_split($this->data['acc_config']->unidades);    
    $this->data['bancos'] = $payments['bancos'];
    $this->data['paypals'] = $payments['paypals'];
    $this->data['logo_url'] = base_url() . 'images/' . $perfil->logo_url;
    $this->data['perfil'] = json_encode($perfil);
    $this->data['mainview'] = 'user/cuenta/index';
    $this->load->view('user/template/main_body', $this->data);
  }

  function guardar()
  {

    $rules = $this->account_m->_update;
    $this->form_validation->set_rules($rules);
    if ($this->form_validation->run() == TRUE) {

      $data = $this->account_m->array_from_post(
        array(
          'nombre_empresa', 'telefono', 'direccion',
          'email', 'poblacion', 'codigo_postal', 'provincia', 'cif'
        )
      );

      if ($this->account_m->guardar($data) == TRUE) {
        $message = alert_msg('Datos actualizados!', 'success');
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

  function do_upload()
  {

    $licencia = $this->session->licencia;
    $config = array(
      'upload_path' => "./images",
      'allowed_types' => "gif|jpg|png|jpeg|pdf",
      'file_name' => 'logo_' . $licencia,
      'overwrite' => TRUE,
      'max_size' => "10048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
      'max_height' => "1500",
      'max_width' => "1500",
    );
    $this->load->library('upload', $config);

    if ($this->upload->do_upload()) {

      $this->data['upload_data'] = $this->upload->data();
      $filename = $this->data['upload_data']['file_name'];
      $message = 'Logo subido con exito!';
      $data = array('result' => 'success', 'img' => base_url() . 'images/' . $filename, 'msg' => alert_msg($message, 'success'));
      $this->account_m->guardar_logo($filename);
      echo json_encode($data);
    } else {
      $error = $this->upload->display_errors();
      $data = array(
        'result' => 'error',
        'msg' => alert_msg($error, 'warning')
      );
      echo json_encode($data);
    }
  }
}
