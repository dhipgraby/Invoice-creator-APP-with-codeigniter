<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Update extends Buster_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('stripe_m');
        $this->load->model('subscription_m');
        require('stripe/autoload.php');
        \Stripe\Stripe::setApiKey(config_item('stripe_secret_key'));
        $this->current_subscription = $this->subscription_m->get_subscription();
        //CHECKING THAT THE SUBSCRIPTION EXIST
        if ($this->current_subscription == FALSE) {
            $this->login_m->logout();
            redirect('main');
            return FALSE;
        }
        //CUSTOMER AND SUBSCRIPTION INFO
        $this->customer = \Stripe\Customer::retrieve($this->current_subscription->customer);
        $this->subscription = \Stripe\Subscription::retrieve($this->current_subscription->subscription_id);
    }
  
    function cancel_subscription()
    {
       if($this->_cancel_rule() == FALSE){
        echo alert_msg('No puede cancelar una subscripción 5 dias antes de su renovación. Para mas información contacte a soporte', 'info');
           return FALSE;
       }
        //$this->subscription->cancel();
        $script = '<script> setTimeout(function(){
            go_to("main");
        },5000); </script>';
        $data = array('status' => 'canceled');
        $this->stripe_m->update_invoice($this->current_subscription->customer, $data);
        $this->login_m->logout();
        echo alert_msg('Su subscripción ha sido cancelada. Podra renovarla para en un plazo máximo de 15 dias', 'info').$script;        
    }

    function checkout()
    {
        $plan_name = $_POST['plan_name'];
        $this->session->plan_id = $plan_name;
        if (!in_array($plan_name, config_item('plan_type'))) {
            $msg = 'Plan no disponible. Contacte a soporte para mas información';
            echo json_alert('error', 'warning', $msg);
            return FALSE;
        }

        $msg = 'Redirigiendo a la plataforma de pago...';
        echo json_alert('success', 'success', $msg, 'PlanId', config_item($plan_name));
    }

    function create_session()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $input = file_get_contents('php://input');
            $body = json_decode($input);
        }
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid request.']);
            exit;
        }
        $checkout_session = \Stripe\Checkout\Session::create([
            'customer' => $this->current_subscription->customer,
            'success_url' => base_url() . 'subscription/update/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => base_url() . 'subscription/update/cancel',
            'payment_method_types' => ['card'],
            'subscription_data' => ['items' => [[
                'plan' => $body->planId,
            ]]]
        ]);
        echo json_encode(['sessionId' => $checkout_session['id']]);
    }

    function checkout_session()
    {
        $id = $_GET['sessionId'];
        if (empty($this->session->plan_id) || empty($id)) {
            return FALSE;
        }        
        $checkout_session = \Stripe\Checkout\Session::retrieve($id);
        $checkout_json = json_decode(json_encode($checkout_session), true);
        $customer_id =  $checkout_json['customer'];
        $subscription_id = $checkout_json['subscription'];
        $plan_id =  $checkout_json['display_items'][0]['plan']['id'];

        $subscription = \Stripe\Subscription::retrieve($subscription_id);
        if ($subscription->status != 'active') {
            unset($_SESSION['plan_id']);
            return FALSE;
        }
        //CANCELING CURRENT SUBSCRIPTION 
        $this->subscription->cancel();

        $data = array(
            'subscription_id' => $subscription_id,
            'plan_id' => $plan_id,
            'next_payment' => $subscription->current_period_end,
            'status' => $subscription->status,
            'datecreate' => date('Y-m-d h:i:s'),
        );

        if ($this->stripe_m->update_invoice($customer_id, $data) == TRUE) {
            unset($_SESSION['plan_id']);
            echo json_encode($checkout_session);
        }
    }

    function success()
    {        
        $this->data['mainview'] = 'subscription/success';
        $this->load->view('user/template/main_body', $this->data);
    }

    function cancel()
    {
        $this->data['plan_name'] = $this->session->plan_name;
        $this->data['mainview'] = 'subscription/cancel';
        $this->load->view('user/template/main_body', $this->data);
    }

    function plan_nickname($id)
    {
        switch ($id) {
            case 'SLIV_001':
                return 'Slapp Basic';
                break;
            case 'SLIV_002':
                return 'Slapp Premium';
                break;
            case 'SLIV_003':
                return 'Slapp Ultimate';
                break;
        }
    }

    function _cancel_rule()
    {
        $expire_date = $this->current_subscription->next_payment;
        $current_time = strtotime('+5 days');         
        if($current_time < $expire_date){         
           return TRUE;
        }      
        return FALSE;
    }

    function config_init()
    {
        echo json_encode([
            'publicKey' => config_item('stripe_publishable_key'),
            'basicPlan' =>  config_item('basic_plan_id'),
            'PremiumPlan' =>  config_item('premium_plan_id'),
            'UltimatePlan' =>  config_item('ultimate_plan_id')
        ]);
    }
}
