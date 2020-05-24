<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Password_reset extends Frontend_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('recover_m');
        $this->load->model('email_m');
    }

    public function index()
    {
        $this->data['mainview'] = 'recover/password';
        $this->load->view('user/main_body', $this->data);
    }

    public function reset()
    {
        $rules = $this->recover_m->_email;
        $this->form_validation->set_rules($rules);
        //Process the from
        if ($this->form_validation->run() == FALSE) {
            echo alert_msg(validation_errors(), 'warning');
            return FALSE;
        }
        $user = $this->db->where('email', $_POST['email'])->get('users')->row();
        if (empty($user)) {
            echo alert_msg('No existe una cuenta relacionada a este email.', 'warning');
            return FALSE;
        } 
        //CREA UNA NOTIFICACION EN AUTH
        if ($this->recover_m->_password_recover($_POST['email'],$user) == FALSE) {
            echo alert_msg('Error en este email o cuenta inválida, <a href="https://slappinvoice.com/soporte/">contacte a soporte</a>', 'warning');
            return FALSE;
        }
        $code = $this->recover_m->_get_current_code($_POST['email']);
        if (empty($code)) {
            echo alert_msg('Error al generar su código, intente nuevamente o <a href="https://slappinvoice.com/soporte/">contacte a soporte</a>', 'warning');
            return FALSE;
            log_message('error', 'email:' . $_POST['email'] . ' code error');
        }
        $this->session->firstname = $user->firstname;  
        //ENVIA EL CORREO
        $this->data['first_msg'] = 'Hola ' . $user->firstname . ' <br> Recuperación de contraseña.';
        $this->data['second_msg'] = 'Ha solicitado un cambio de contraseña. Para realizar los cambios acceda a este link:<br>
         <a href="' . base_url('password_reset/new_password?code=' . $code->code) . '">' . base_url('password_reset/new_password?code=' . $code->code) . '</a>';
        $this->data['third_msg'] = 'Si no ha solicitado este cambio de contraseña puede <span class="c-red">cancelar la solicitud </span> accediendo a este link:
        <a href="' . base_url('password_reset/cancel_code?code=' . $code->code) . '">' . base_url('password_reset/cancel_code?code=' . $code->code) . '</a>';
        $template = $this->load->view('email/main_template', $this->data, TRUE);

        if ($this->email_m->_recovery_email($_POST['email'],$template) == FALSE) {            
            echo alert_msg('Error al enviar el correo, intente nuevamente o <a href="https://slappinvoice.com/soporte/">contacte a soporte</a>', 'warning');
            return FALSE;
        }

        $this->session->set_tempdata('user_request', TRUE, 30);
        echo alert_msg('Solicitud de recuperación de contraseña enviada. Revise su correo y entre en el link de recuperación', 'success');
        return TRUE;
    }

    function cancel_code()
    {
        $code = $_GET['code'];
        if (empty($code)) {
            redirect('main');
            return FALSE;
        }
        if ($this->recover_m->_check_code($code) == FALSE) {
            $this->data['mainview'] = 'recover/invalid_code';
        } else {            
           $this->data['mainview'] = 'recover/cancel_code';
           $this->recover_m->_cancel_code($this->session->recovery_email);
        }
        $this->load->view('user/main_body', $this->data);
    }
    public function new_password()
    {
        $code = $_GET['code'];
        if (empty($code)) {
            redirect('main');
            return FALSE;
        }
        if ($this->recover_m->_check_code($code) == FALSE) {
            $this->data['mainview'] = 'recover/invalid_code';
        } else {            
            $this->data['mainview'] = 'recover/set_password';
        }
        $this->load->view('user/main_body', $this->data);
    }

    public function set_password()
    {
        $email = $this->session->recovery_email;
        if(empty($email)){
            echo json_alert('error','warning','Código expirado o email inválido, solicite otro codigo en <a href='.base_url('password_reset').'> Recuperación de contraseña</a>');
            return FALSE; 
        }
        $rules = $this->recover_m->_set_password;
        $this->form_validation->set_rules($rules);
        //Process the from
        if($this->form_validation->run() == FALSE) {                    
            echo json_alert('error','warning',validation_errors());
            return FALSE;
        }
        
        if($this->recover_m->_set_password($email,$this->input->post('password')) == FALSE){
            echo json_alert('error','warning','Error en el cambio de contraseña, intente nuevamente o solicite otro codigo en <a href='.base_url('password_reset').'> Recuperación de contraseña</a>');
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

    function _old_password_check()
    {
        $this->load->model('rules_m');
        return $this->rules_m->_old_password_check();
    }

    function _email_timer()
    {
        $this->load->model('email_m');
        return $this->email_m->_email_timer();
    }
}
