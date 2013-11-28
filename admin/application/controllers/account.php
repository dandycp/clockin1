<?php 
require_once APPPATH . '/libraries/payload.php';

class Account extends MY_Controller
{


	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		//$this->output->enable_profiler(TRUE);

		$this->load->vars();
	}
	
	function login()
	{
		$error = NULL;
		
		if ($this->input->post()) {
			// try to log user in
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			
			if ($this->auth->login($email, $password)) {
				$redirect_url = '/account/welcome';
				/*
				 * Redirects user to the last page which they tried to access (when they were logged out)
				 * - unwanted feature - removed July 2013
				 
				if ($this->session->userdata('redirect_url')) {
					$redirect_url = $this->session->userdata('redirect_url');
					$this->session->unset_userdata('redirect_url');
				}
				*/
				redirect($redirect_url);
			}
			$error = 'Account details incorrect';
		}
		$this->load->view('account/login', compact('error'));
	}
	
	function index()
	{
		if (!$this->user) redirect('/account/login');
		else redirect('/account/welcome');
	}
	
	function welcome()
	{
		if (!$this->user) redirect('/account/login');
		$devices = $this->user->own('device');
		$device = ($devices) ? $devices[0] : null ;
		$this->load->view('account/welcome', compact('device'));
	}
	
	function logout()
	{
		$this->auth->logout();
		redirect('/account/login');
	}
	
	// generic informational page
	function upgrade_benefits()
	{
		$title = 'Upgrade Benefits';
		$this->load->view('account/upgrade_benefits', compact('title'));
	}

	
	// either show upgrade information or update the number of devices allowed on the account
	function change_package()
	{
		$this->auth->action('change_package', 'account');
		$error = false;
		$account = $this->account;
		
		if ($new_limit = $this->input->post('device_limit')) {
			try {
				$current_limit = $account->device_limit;
				$action = ($new_limit > $current_limit) ? 'upgrade' : 'downgrade';
				if ($new_limit == $current_limit) throw new Exception('New limit is the same as your existing limit');
				if ($new_limit < $account->number_of_devices()) throw new Exception('Your chosen limit is lower than the number of devices you currently have set up. Delete unwanted devices from your account to proceed.');
				
				$result = $account->has_valid_payment_details();
				
				if ($action == 'upgrade' && !$account->has_valid_payment_details()) 
					redirect('/payments/add_card');
				
				// calculate the new amounts
				$this->load->model('model_pricing', 'pricing');
				$new_amount = $this->pricing->get_price($new_limit, 'year');
								
				// see if they have a subscription already in place
				$old_subscription = $account->subscription();
				
				if ($old_subscription) {
					
					// inactivate the old subscription
					$old_subscription->active = 0;
					R::store($old_subscription);
					
					$old_amount = $old_subscription->amount;
					
					
					if ($action == 'downgrade') {
						$initial_amount = 0;
					} else {
						$fraction_used = $old_subscription->fraction_used();
						$fraction_left = $old_subscription->fraction_left();
						
						$cost_so_far = $old_amount * $fraction_used;
						$new_fractional_amount = $new_amount * $fraction_left;
						
						$cost_for_this_period = $cost_so_far + $new_fractional_amount;
						
						$initial_amount = $cost_for_this_period - $old_amount;
					}
				} else {
					// they are having a subscription for the first time	
					$initial_amount = $new_amount;
				}
				// create a new subscription
				$new_subscription = R::dispense('subscription');
				$new_subscription->interval = 'year';
				$new_subscription->initial_amount = $initial_amount;
				$new_subscription->amount = $new_amount;
				$new_subscription->num_devices = $new_limit;
				$new_subscription->account_id = $account->id;
				
				// activate the new subscription
				R::store($new_subscription);
				
				// update the main account record
				$account->device_limit = $new_limit;
				$account->type = $this->input->post('type'); // todo - further checks
				R::store($account);
				
				// send user an email confirming their choice
				$subscription = R::load('subscription', $new_subscription->id);
				$account = $this->account;
				$message = $this->load->view('account/subscription_email', compact('subscription','account'), true);
				$this->load->library('email');
				$config['charset'] = 'utf-8';
				$config['mailtype'] = 'html';

				$this->email->initialize($config);
				$this->email->from('info@clockinpoint.com', 'Clock in Point');
				$this->email->to($this->account->user->email);		
				$this->email->subject('ClockinPoint - Subscription Confirmation');
				$this->email->message($message);
				$this->email->send();
				// dev only: $this->email->print_debugger();
				
				$this->session->set_userdata('old_subscription_id', $old_subscription->id);
				$this->session->set_userdata('new_subscription_id', $new_subscription->id);
				
				redirect('/account/package_changed');
				
				
			} catch (Exception $e) {
				$error = $e->getMessage();
			}
		}
		$title = 'Change Package';
		$this->load->view('account/change_package', compact('error','account','title'));	
	}
	
	
	// their package has been changed - show details of amounts and dates
	function package_changed()
	{
		$old_subscription_id = $this->session->userdata('old_subscription_id');
		$new_subscription_id = $this->session->userdata('new_subscription_id');
		
		if (!$new_subscription_id) show_404();
		
		if (!$old_subscription_id) $old_subscription = R::dispense('subscription');
		else $old_subscription = R::load('subscription', $old_subscription_id);
		
		$new_subscription = R::load('subscription', $new_subscription_id);
		$account = $this->account;
		$title = 'Package Changed';
		$this->load->view('account/package_changed', compact('old_subscription','new_subscription','account','title'));
		
	}
	
	function create()
	{
		$error = false;
		$account = R::dispense('account');
		$user = R::dispense('user');
		$address = R::dispense('address');		
		$countries = R::findAll('country', 'ORDER BY name');
		
		if ($data = $this->input->post()) {
			
			try {
				
				$user->import($data, 'title,first_name,last_name,tel,email,password');
				$account->import($data, 'company_name,business_type,type,tolerance_rate');
				$address->import($data['address'], 'line_1,line_2,city,postcode,country_id');
				
				if ($data['email'] != $data['email2']) throw new Exception('Emails must match');
				if ($data['password'] != $data['password2']) throw new Exception('Passwords must match');
				if (empty($data['agree_to_terms'])) throw new Exception('Agreement to our Terms is required');
				
				
				// set up user defaults
				$user->usergroup_id = 1; // the default 'Admins' group
				$user->last_login = date("Y-m-d H:i:s");
				$user->account = $account;
				
				// set up account defaults
				$account->show_clients = ($account->type == 'provider') ? 1 : 0 ;
				$account->show_devices = ($account->type == 'provider') ? 0 : 1 ;
				$account->type = 'basic'; // always basic on signup				
				
				// start a transaction so that any errors whilst saving can be reversed
				R::begin();
				try{
					$address_id = R::store($address);
					$user_id = R::store($user);
					$account->user_id = $user_id;
					$account->postal_address_id = $address_id;
					R::store($account);
					R::commit();
				}
				catch(Exception $e) {
					R::rollback();
					throw new Exception($e->getMessage());
				}
				
				$this->session->set_flashdata('message', 'Thank you. Your account has been created');
				
				// send user a welcome email
				$message = auto_link('Thank you for registering at www.clockinpoint.com. You may now login at any time using your email address ('.$user->email.') and chosen password.','url');
				
				$this->load->library('email');
				$config['charset'] = 'utf-8';
				$config['mailtype'] = 'html';
				$this->email->from('info@clockinpoint.com', 'Clock in Point');
				$this->email->to($user->email);
				//$this->email->bcc('andycoatz@gmail.com');			
				$this->email->subject('Registration Confirmation');
				$this->email->message($message);
				$this->email->send();
				// dev only: $this->email->print_debugger();
				
				// log user in
				$this->session->set_userdata('user_id', $user_id);
				
				// redirect to the appropriate place for their account type
				if ($account->show_clients == 1) redirect('/clients/add');
				else redirect('/devices/add');
				
			} catch (Exception $e) {
				$error = $e->getMessage();
			}
		}
		
		$this->load->view('account/create', compact('user','account','countries','address','error','data'));
	}
	
	function forgot_password()
	{
		$data['email'] = '';
		$error = false;
		if ($data = $this->input->post()) {
			$user = R::findOne('user', 'email=?', array($data['email']));
			if (!$user) {
				$error = 'A user with this email address could not be found';
			}
			else {
				
				$this->load->library('encrypt');
				$key = $this->encrypt->encode($user->id);

				$link = base_url() . 'account/reset_password?key=' . urlencode($key);
				$message = 'Please click the following link below to reset your password: ' . $link;
				$message = auto_link($message);
				
				$this->load->library('email');
				$config['charset'] = 'utf-8';
				$config['mailtype'] = 'html';
				$this->email->from('info@clockinpoint.com', 'Clock in Point');
				$this->email->to($user->email);
				// $this->email->bcc('andycoatz@gmail.com');				
				$this->email->subject('Clock In Point - Password Reset');
				$this->email->message($message);
				$this->email->send();
				// dev only: $this->email->print_debugger();
				redirect('/account/forgot_password_complete');
			}
		}
		$this->load->view('account/forgot_password', compact('error','data'));	
	}
	
	function forgot_password_complete()
	{
		$this->load->view('account/forgot_password_complete');	
	}
	
	// usually accessed via an email link
	function reset_password()
	{
		$key = $this->input->get('key');
		if (!$key) die('Key not found. If you clicked a link to get here, then try copying and pasting it instead.');
		$this->load->library('encrypt');
		$id = $this->encrypt->decode($key);
		$user = R::load('user', $id);
		if (!$user) die('User not found');
		$this->session->set_flashdata('message', 'You may now change your password');
		$user->last_login = date("Y-m-d H:i:s");
		R::store($user);
		$this->session->set_userdata('user_id', $user->id);
		redirect('account/edit_profile');
	}
	
	function edit()
	{		
		$error = false;
		$account = $this->account;
		$address = $account->fetchAs('address')->postal_address;
		$card = R::findOne('card', 'account_id = ? ORDER BY added_at DESC', array($account->id));
		$countries = R::find('country', '1 ORDER BY name');
		
		if ($data = $this->input->post()) {
			try {
				
				$account->import($data, 'company_name,business_type,show_clients,show_devices,custom_1_name,custom_2_name,tolerance_rate,email_notifications');
				$address->import($data['address'], 'line_1,line_2,city,postcode,country_id');
				
				if (!isset($data['show_clients'])) $account->show_clients = 0;
				if (!isset($data['show_devices'])) $account->show_devices = 0;
				
				R::store($account);
				//R::store($address);
				
				$this->session->set_flashdata('message', 'Account details successfully updated');
				redirect('/account/edit');
			} catch (Exception $e) {
				$error = $e->getMessage();
			}
		}
		$title = 'Edit My Account';
		$this->load->view('account/edit', compact('account','countries','address','error','card','title'));
	}
	
	function edit_payment_details()
	{
		$this->auth->action('edit_payment_details', 'account');
		$countries = R::find('country', '1 ORDER BY name');
		$this->load->view('account/edit_payment_details', compact('countries'));
	}

	// Notifications
	function notifications()
	{
		// Load Notification Model
		$this->load->model('client_m');
		$this->load->model('invoice_model');
        $this->load->model('notify_model');
		$this->load->library('email');
		$account_id = $this->session->userdata('account_id');
		
		$invoice = $this->invoice_model->get_invoices_unpaid();

        $notifications = $this->notify_model->get_messages($account_id);
		/*
		$error = false;
		$today = date('j F Y H:i');
		
		$client = $this->client_m->get_account_for_notifications();
		$user = $this->client_m->get_user_infofor_notifications();


		$send_notification = $client->hour_rate;
		$tolerance = $client->tolerance_rate;
		$email_notice = $client->email_notifications;

		$this->client_m->update_messages();
		
		// Gets 1st day of month then 31 days after
		$first = date('d-m-Y', mktime(0, 0, 0, date('m'), date('01'), date('Y')));
		$last  = date('d-m-Y',mktime(0, 0, 0, date("m")  , date("d")+31, date("Y")));

		$rate = $this->client_m->fetch_rate();
		$rt = $rate->hour_rate;
		*/

		//$rate = R::findOne('account', 'hour_rate=?', array($rate));
	
		//if ($existing > $existing) throw new Exception('More than');
		//if ($existing < $existing) throw new Exception('Less then');


		/* Uncomment once all tested
		if ($send_notification == 0 && $send_notification != 1 && $first != $last && $email_notice != 0) {
			// Email the user
			$config['mailtype'] = 'html';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;

			$this->email->initialize($config);


			// All fields for email		
			$name  = $user->first_name;
			$email = $user->email;
			$logo  = base_url().'images/logo-mpdf.png';
			
			$message = "<img src='$logo' /><br /><br />
						Hello $name,<br />
						You have new notifications in your Clock In Point account.<br /><br />
						Please click <a href='http://www.clockinpoint.com/admin/clients'>here</a> to login to your account.<br /><br />
						<strong>Generated by Clock In Point - $today </strong>
						<br /><br />
						<strong><a href='http://www.clockinpoint.com'>www.clockinpoint.com</a></strong>
						";
				
			
			$this->email->from('info@clockinpoint.com');
			$this->email->to('lstables1@gmail.com');
			$this->email->subject('Clock In Point - You have new notifications');
					
			$this->email->message($message);
			
			$this->email->send(); 
			$this->email->clear();
		}
		*/
		$title = 'Notifications';
		$this->load->view('account/notify', compact(
            'title','rate','client','user','account_id','today','rate','rt','first','last','invoice','notifications'
        ));
	}
	

}