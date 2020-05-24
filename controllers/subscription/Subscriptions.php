<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subscriptions extends Buster_Controller
{

   function __construct()
   {
      parent::__construct();
      $this->load->model('stripe_m');   
      $this->data['page_script'] = 'user/js/subscription';
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

   function index()
   {
      $id = $this->customer->invoice_settings->default_payment_method;
      $this->basic_info();
      $this->payment_info($id);
      $this->data['mainview'] = 'subscription/index';
      $this->load->view('user/template/main_body', $this->data);
   }

   private function basic_info()
   {
      $this->data['proximo_pago'] = $this->subscription->current_period_end;
      $this->data['comienzo'] = $this->subscription->created;
      $this->data['plan_name'] = $this->subscription->plan->nickname;
      $this->data['status'] = $this->current_subscription->status;
      $this->data['subscription_id'] = $this->subscription->plan->id;
   }

   private function payment_info($id)
   {
      $this->method = \Stripe\PaymentMethod::retrieve($id);
      $this->data['last4'] = $this->method->card->last4;
      $this->data['card_type'] = $this->method->card->brand;
      $this->data['card_email'] = $this->method->billing_details->email;
      $this->data['card_name'] = $this->method->billing_details->name;
   }

   public function save_card()
   {
      $rules = $this->subscription_m->_add_card;
      $this->form_validation->set_rules($rules);
      if ($this->form_validation->run() == FALSE) {
         echo json_alert('error','warning',validation_errors());
         return FALSE;
      }
      try {
         $new_card = \Stripe\PaymentMethod::create([
            'type' => 'card',
            'card' => [
               'number' => strval($_POST['card_num']),
               'exp_month' => $_POST['card_month'],
               'exp_year' => substr(date('Y'), 0, 2) . $_POST['card_year'],
               'cvc' => strval($_POST['card_cvc']),
            ],
            'billing_details' => ['name' => $_POST['card_name']],
         ]);
         $this->set_pm($new_card->id);         
         echo json_alert('success','success','Metodo de pago actualizado','pm_id',$new_card->id);
         return TRUE;
      } catch (Exception $e) {
         $error = 'Algun dato de esta tarjeta es invalido';
         echo json_alert('error','warning',$error);
         //echo alert_msg($e->getMessage(), 'warning');
         return FALSE;
      }
   }

   private function set_pm($id)
   {
      //DISTACH DEFAULT CUSTOMER PAYMENT METHOD 
      $old_payment_method = \Stripe\PaymentMethod::retrieve(
         $this->customer->invoice_settings->default_payment_method
      );
      $old_payment_method->detach();
      //SET NEW DEFAULT CUSTOMER PAYMENT METHOD
      $payment_method = \Stripe\PaymentMethod::retrieve(
         $id
      );
      $payment_method->attach([
         'customer' => $this->current_subscription->customer,
      ]);
      //UPDATING NEW METHOD
      \Stripe\Customer::update(
         $this->current_subscription->customer,
         ['invoice_settings' => ['default_payment_method' => $id]]
      );
   }

   public function update_info($id)
   {
      $this->payment_info($id);
      $this->load->view('subscription/info_pago', $this->data);
   }

   //RULES 
   public function _valid_year()
   {
      return $this->subscription_m->_valid_year();
   }
}
