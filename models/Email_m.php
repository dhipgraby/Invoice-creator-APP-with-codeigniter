<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Email_m extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        require('vendor/autoload.php');
        $this->load->library('email');        
        $this->sengrid_email = new \SendGrid\Mail\Mail();
        $this->sendgrid = new \SendGrid('api key');        
    }

    public function _wellcome_email($email,$template)
    {     
        $this->sengrid_email->setFrom("soporte@slappinvoice.com", "Slapp Invoice Soporte");
        $this->sengrid_email->setSubject("Bienvenido. Cuenta ". $this->session->plan_nickname." activa.");
        $this->sengrid_email->addTo($email, $this->session->firstname);
        $this->sengrid_email->addContent(
            "text/html",
            $template
        );
        $response = $this->sendgrid->send($this->sengrid_email);
        return ($response->statusCode() == 202) ? TRUE : FALSE;
    }

    public function _add_user($email,$template)
    {    
        $this->sengrid_email->setFrom("cuentas@slappinvoice.com", "Slapp Invoice cuentas");
        $this->sengrid_email->setSubject("Invitación de colaboración como usuario de SlappInvoice.");
        $this->sengrid_email->addTo($email, 'Nuevo usuario');
        $this->sengrid_email->addContent(
            "text/html",
            $template
        );
        $response = $this->sendgrid->send($this->sengrid_email);
        return ($response->statusCode() == 202) ? TRUE : FALSE;
        
    }

    function _recovery_email($email, $template)
    {
        $this->sengrid_email->setFrom("soporte@slappinvoice.com", "Slapp Invoice Soporte");
        $this->sengrid_email->setSubject("Recuperación de contraseña");
        $this->sengrid_email->addTo($email, $this->session->firstname);
        $this->sengrid_email->addContent(
            "text/html",
            $template
        );
        $response = $this->sendgrid->send($this->sengrid_email);
        return ($response->statusCode() == 202) ? TRUE : FALSE;
    }

    function _framework_email($email,$template,$subject)
    {   
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from('soporte@slappinvoice.com', 'Slapp Invoice Soporte');
        $this->email->to($email);
        $this->email->subject($subject);       
        $this->email->message($template);
        $send = $this->email->send();
        if (!$send) {
            log_message('error','email not send to '.$email);
            return FALSE;
        }
        return TRUE;
    }
    //UNIQUE CODE FOR EMAIL
    function rand_user_code()
    {
        $u_code = randLetter() . mt_rand(10, 100) . randLetter() . mt_rand(1000, 99999) . randLetter();
        return $u_code;
    }
    //CHECK IF EMAIL CODE IS EXPIRED
    function _email_timer()
    {
        if ($this->session->tempdata('user_request') == TRUE) {
            $this->form_validation->set_message('_email_timer', 'Acaba de enviar una solicitud. Espere 1 minuto para enviar una nueva solicitud.');
            return FALSE;
        }
        return TRUE;
    }
}
