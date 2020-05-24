<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stripe_m extends MY_Model
{


    function __construct()
    {
        parent::__construct();
    }

    function save_invoice($data)
    {
        $this->db->set($data);
        if ($this->db->insert('stripe')) {
            return TRUE;
        }
        return FALSE;
    }

    function update_invoice($id, $data)
    {
        $this->db->where('customer', $id)->set($data);
        if ($this->db->update('stripe')) {
            $this->db->where('licencia',$this->session->licencia)->set('plan_id',$this->session->plan_id)->update('users');
            return TRUE;            
        }
        return FALSE;
    }

    function check_stripe_customer($id)
    {
        $customer = $this->db->where('user_id',$id)->get('stripe')->row();
        if (!empty($customer)) {
            return $customer;
        }
        return FALSE;
    }

    function check_plan($sub_id)
    {
        $user_subscription = $this->db->where('subscription_id', $sub_id)->get('stripe')->result();
        if (!empty($user_subscription)) {
            return TRUE;
        }
        return FALSE;
    }


}
