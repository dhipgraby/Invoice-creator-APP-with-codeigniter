<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends Buster_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('payment_m');
    }

    function add_banc()
    {

        $banco = $_POST['banco'];
        $cuenta = $_POST['cuenta'];
        $bic = $_POST['bic'];

        $rules = $this->payment_m->banc;
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == TRUE) {

            $data = array('nombre' => $banco, 'cuenta' => $cuenta, 'bic' => $bic);

            if ($this->payment_m->add_banc($data) == TRUE) {
                $message = 'Nuevo banco agregado!';
                $id = $this->payment_m->max_id('bancos');
                echo json_alert('success', 'success', $message, 'id', $id);
            } else {
                $message = 'Error en los campos';
                echo json_alert('error', 'warning', $message);
            }
        } else {
            $errors = validation_errors();
            echo json_alert('error', 'warning', $errors);
        }
    }

    function add_paypal()
    {

        $email = $_POST['email'];

        $rules = $this->payment_m->paypal;
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == TRUE) {

            if ($this->payment_m->add_paypal($email) == TRUE) {
                $message = 'Nuevo email de Paypal agregado!';
                $id = $this->payment_m->max_id('paypal');
                echo json_alert('success', 'success', $message, 'id', $id);
            } else {
                $message = 'Error en el email o email existente';
                echo json_alert('error', 'warning', $message);
            }
        } else {
            $errors = validation_errors();
            echo json_alert('error', 'warning', $errors);
        }
    }

    function edit_banc($id)
    {
        $banc = $this->db2->where('id', $id)->get('bancos')->row();
        if (empty($banc)) {
            return FALSE;
        }
        $this->session->set_userdata('cuenta', $id);
        $banco = $_POST['banco'];
        $cuenta = $_POST['cuenta'];
        $bic = $_POST['bic'];

        $rules = $this->payment_m->banc_edit;
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == TRUE) {

            $data = array('nombre' => $banco, 'cuenta' => $cuenta, 'bic' => $bic);

            if ($this->payment_m->update_banc($id, $data) == TRUE) {
                $message = 'Detalles de banco modificados';
                echo json_alert('success', 'success', $message);
            } else {
                $message = 'No se ha realizado ningún cambio';
                echo json_alert('error', 'info', $message);
            }
        } else {
            $errors = validation_errors();
            echo json_alert('error', 'warning', $errors);
        }
    }

    function edit_paypal($id)
    {
        $paypal = $this->db2->where('id', $id)->get('paypal')->row();
        if (empty($paypal)) {
            return FALSE;
        }

        $email = $_POST['email'];
        $this->session->set_userdata('paypal', $id);

        $rules = $this->payment_m->paypal_edit;
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == TRUE) {

            if ($this->payment_m->update_paypal($id, $email) == TRUE) {
                $message = 'Email de Paypal modificado!';
                echo json_alert('success', 'success', $message);
            } else {
                $message = 'No se ha realizado ningún cambio';
                echo json_alert('error', 'info', $message);
            }
        } else {
            $errors = validation_errors();
            echo json_alert('error', 'warning', $errors);
        }
    }

    function delete($id)
    {

        $method = $_POST['method'];
        if ($this->payment_m->delete_method($id, $method) == TRUE) {
            $message = 'Metodo de pago eliminado';
            echo alert_msg($message, 'success');
        } else {
            $errors = 'Error al eliminar, recargue la aplicación.';
            echo alert_msg($errors, 'warning');
        }
    }

    function set_current($id)
    {

        $method = $_POST['method'];

        if ($this->payment_m->set_current($id, $method) == FALSE) {
            $errors = 'Error en esta opción, recargue la aplicación.';
            echo alert_msg($errors, 'warning');
        }
        $message = 'Opción de pago predeterminada en ' . $method;
        echo alert_msg($message, 'success');
    }

    function current_option($num)
    {

        if ($this->payment_m->current_option($num) == FALSE) {
            $errors = 'Error en esta opción, recargue la aplicación.';
            echo alert_msg($errors, 'warning');
        }
        $message = 'Opción de pago predeterminada';
        echo alert_msg($message, 'success');
    }

    function get_table($name)
    {
        $payments = $this->payment_m->get_methods();
        $this->data['bancos'] = $payments['bancos'];
        $this->data['paypals'] = $payments['paypals'];

        if ($name == 'paypal') {
            $this->load->view('user/cuenta/pago/paypal_table', $this->data);
        }
        if ($name == 'bancos') {
            $this->load->view('user/cuenta/pago/bancos_table', $this->data);
        }
    }

    function _unique_edit_paypal()
    {
        return $this->rules_m->_unique_edit_paypal();
    }

    function _unique_paypal()
    {
        return $this->rules_m->_unique_paypal();
    }

    function _unique_edit_banc()
    {
        return $this->rules_m->_unique_edit_banc();
    }

    function _unique_banc()
    {
        return $this->rules_m->_unique_banc();
    }
}
