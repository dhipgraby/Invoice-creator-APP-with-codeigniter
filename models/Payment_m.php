<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment_m extends MY_Model
{

    public $paypal = array(

        'email' => array(
            'field' => 'email',
            'label' => '<b>Email</b>',
            'rules' => 'trim|required|valid_email|callback__unique_paypal'
        ),
    );

    public $paypal_edit = array(

        'email' => array(
            'field' => 'email',
            'label' => '<b>Email</b>',
            'rules' => 'trim|required|valid_email|callback__unique_edit_paypal'
        ),
    );

    public $banc = array(

        'banco' => array(
            'field' => 'banco',
            'label' => '<b>Nombre entidad</b>',
            'rules' => 'trim|required|xss_clean'
        ),

        'cuenta' => array(
            'field' => 'cuenta',
            'label' => '<b>Número de cuenta</b>',
            'rules' => 'trim|required|min_length[22]|callback__unique_banc'
        ),

    );

    public $banc_edit = array(

        'banco' => array(
            'field' => 'banco',
            'label' => '<b>Nombre entidad</b>',
            'rules' => 'trim|required|xss_clean'
        ),

        'cuenta' => array(
            'field' => 'cuenta',
            'label' => '<b>Número de cuenta</b>',
            'rules' => 'trim|required|min_length[22]|callback__unique_edit_banc'
        ),

    );


    function __construct()
    {
        parent::__construct();
    }

    function get_methods()
    {
        $this->db2->order_by('current','desc');   
        $bancos = $this->db2->get('bancos')->result();
        $this->db2->order_by('current','desc');
        $paypal = $this->db2->get('paypal')->result();
        $data['bancos'] = $bancos;
        $data['paypals'] = $paypal;
        return $data;
    }

    function add_banc($data)
    {
        if (empty($data)) {
            return FALSE;
        }
        $this->db2->set($data);
        if ($this->db2->insert('bancos')) {
            return TRUE;
        }
    }

    function add_paypal($email)
    {
        if (empty($email)) {
            return FALSE;
        }
        $this->db2->set('email', $email);
        if ($this->db2->insert('paypal')) {
            return TRUE;
        }
    }

    function update_paypal($id, $email)
    {

        if (empty($email)) {
            return FALSE;
        }

        $this->db2->where('id', $id)
            ->set('email', $email)
            ->update('paypal');

        return ($this->db2->affected_rows() < 1) ? FALSE : TRUE;
    }

    function update_banc($id, $data)
    {

        if (empty($data)) {
            return FALSE;
        }

        $this->db2->where('id', $id)
            ->set($data)
            ->update('bancos');

        return ($this->db2->affected_rows() < 1) ? FALSE : TRUE;
    }

    function delete_method($id, $method)
    {

        if (empty($id)) {
            return FALSE;
        }

        $this->db2->where('id', $id)->delete($method);
        return ($this->db2->affected_rows() < 1) ? FALSE : TRUE;
    }

    function set_current($id, $method)
    {

        if (empty($id)) {
            return FALSE;
        }
        $this->db2->where('id >', 0)->set('current', '0')->update($method);
        $this->db2->where('id', $id)->set('current', 1)->update($method);
        return ($this->db2->affected_rows() < 1) ? FALSE : TRUE;
    }

    function current_option($method)
    {

        $this->db2->set('current', $method)->update('payment_conf');
        return TRUE;
    }

    function max_id($name)
    {

        $id = $this->db2->select_max('id', 'max_id')->limit(1)->get($name)->row()->max_id;
        return $id;
    }
}
