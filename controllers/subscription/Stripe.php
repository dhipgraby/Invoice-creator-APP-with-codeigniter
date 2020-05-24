<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stripe extends Frontend_Controller
{

   function __construct()
   {
      parent::__construct();
      $this->load->model('stripe_m');
      $this->load->model('subscription_m');
      require('stripe/autoload.php');
      \Stripe\Stripe::setApiKey(config_item('stripe_secret_key'));
      $this->data['stripe_js'] = TRUE;
  
   }

   //PASO 1. CHECKEA EL PLAN DISPONIBLE Y REDIRECCIONA A LA PLATAFORMA DE PAGO
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


    //PASO 2. PREPARA LA INFORMACION DEL CLIENTE ANTES DE ACTUALIZAR SUBSCRIPCION COMO VÁLIDA Y METODO DE PAGO
   function create_session()
   {
      if(empty($this->session->user_email)){
         return FALSE;
      }
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         $input = file_get_contents('php://input');
         $body = json_decode($input);
      }
      if (json_last_error() !== JSON_ERROR_NONE) {
         http_response_code(400);
         echo json_encode(['error' => 'Invalid request.']);
         exit;
      }

      $owner_user = $this->db->where('email',$this->session->user_email)->get('users')->row();
      $customer = $this->stripe_m->check_stripe_customer($owner_user->user_id);
      $customer_id = $customer->customer;

      //SI NO HAY USUARIO CREADO EN STRIPE, CREA UNO
      if (empty($customer) || $customer == FALSE) {
         $customer = \Stripe\Customer::create([
            'email' => $owner_user->email,          
         ]);
         
         $customer_id = $customer->id;
         $data = array(
            'customer' => $customer_id,
            'user_id' => $owner_user->user_id,
            'plan_id' => $body->planId,
            'datecreate' => date('Y-m-d h:i:s'),
         );
         //PREPARA LA ORDER DE COBRO ANTES DEL PAGO
         $this->stripe_m->save_invoice($data);
      }
      $checkout_session = \Stripe\Checkout\Session::create([
         'customer' => $customer_id,
         'success_url' => base_url() . 'register/success?session_id={CHECKOUT_SESSION_ID}',
         'cancel_url' => base_url() . 'register/plan_subscription?canceled=true',
         'payment_method_types' => ['card'],
         'subscription_data' => ['items' => [[
            'plan' => $body->planId,
         ]]]
      ]);

      echo json_encode(['sessionId' => $checkout_session['id']]);
   }
   
   //PASO 3. ULTIMA PASO ACTUALIZA INFORMACION DEL CLIENTE. ENVIAR EMAIL DE BIENVENIDA
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
      $nickname =  $checkout_json['display_items'][0]['plan']['nickname'];
      $this->session->plan_nickname = $nickname;

      $subscription = \Stripe\Subscription::retrieve($subscription_id);          
      if($subscription->status != 'active'){
         unset($_SESSION['plan_id']);
         return FALSE;
      }
     
      //DATOS PARA ACTUALIZAR SUBSCRIPCION A ACTIVA
      $data = array(
         'subscription_id' => $subscription_id,
         'plan_id' => $plan_id,
         'next_payment' => $subscription->current_period_end,
         'status' => $subscription->status,
      );   
      $this->load->model('users_db_m');
      $this->load->model('email_m');      
      if($this->users_db_m->asign_db($this->session->user_id) == FALSE){
         return FALSE;
      }
      if($this->stripe_m->update_invoice($customer_id, $data) == FALSE){
         return FALSE;
      }
      // $this->data['first_msg'] = 'Bienvenido a SlappInvoice';
      // $this->data['second_msg'] = 'Su cuenta ' . $this->session->plan_nickname . ' esta ya activa. Puede acceder con sus credenciales a travez de <a href="https://app.slappinvoice.com">app.slappinvoice.com</a>.';
      // $this->data['third_msg'] = 'Si necesita asistencia, soporte o tiene alguna duda puede ponerse en contacto directo aquí: <a href="https://slappinvoice.com/soporte">Soporte</a>';
      // $template =  $this->load->view('email/main_template', $this->data, TRUE);
      // $this->email_m->_wellcome_email($this->session->user_email,$template);
       //ACTUALIZA EL METODO DE PAGO UTILIZADO A PREDETERMINADO
      $this->set_pm($customer_id);
      unset($_SESSION['plan_id']);
      echo json_encode($checkout_session);
   }
   

   //FUNCION PARA ACTIALIZAR EL METODO DE PAGO UTILIZADO EN PASO 2
   private function set_pm($id){
      $methods = \Stripe\PaymentMethod::all([
         'customer' => $id,
         'type' => 'card',
       ]);
       $pm = json_decode(json_encode($methods['data'][0]['id']));
       \Stripe\Customer::update(
         $id,
         ['invoice_settings' => ['default_payment_method' => $pm]]
      );    
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
