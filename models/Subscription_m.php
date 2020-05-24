<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subscription_m extends MY_Model
{

    public $_add_card = array(
        
        'card_name' => array(
            'field' => 'card_name',
            'label' => '<b>Titular de la tarjeta</b>',
            'rules' => 'trim|required'
        ),
        'card_num' => array(
            'field' => 'card_num',
            'label' => '<b>Número de tarjeta</b>',
            'rules' => 'trim|required|numeric|exact_length[16]'
        ),
        'card_month' => array(
            'field' => 'card_month',
            'label' => '<b>Mes</b>',
            'rules' => 'trim|required|numeric|min_length[1]|max_length[2]|less_than[13]'
        ),
        'card_year' => array(
            'field' => 'card_year',
            'label' => '<b>Año</b>',
            'rules' => 'trim|required|numeric|exact_length[2]|callback__valid_year'
        ),
        'card_cvc' => array(
            'field' => 'card_cvc',
            'label' => '<b>CVC</b>',
            'rules' => 'trim|required|numeric|exact_length[3]'
        ),
    );

    function __construct()
    {
        parent::__construct();
    }

    function get_subscription()
    {
        $owner_id = $this->db->where('licencia', $this->session->licencia)
            ->where('owner', 1)->get('users')->row();
        $subscription = $this->db->where('user_id', $owner_id->user_id)
            ->get('stripe')->row();
        if (!empty($subscription)) {
            return $subscription;
        }
        return FALSE;
    }

    function get_plan($id)
    {
        $subscription_info = $this->db->where('plan_id', $id)->limit(1)->get('member_plan')->row();
        return $subscription_info;
    }

    function _valid_year()
    {
        $max_years = substr(date('Y', strtotime('+5 year')), 2);
        if ($_POST['card_year'] > $max_years || $_POST['card_year'] < substr(date('Y'), 2)) {
            $this->form_validation->set_message('_valid_year', 'Introduzca un año de vencimiento válido.');
            return FALSE;
        }
        return TRUE;
    }
}
