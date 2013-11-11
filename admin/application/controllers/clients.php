<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Client Controller
*/
class Clients extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// Load libraries & models
		$this->load->library('auth');
		$this->load->model('client_m');

		$this->account = $this->client_m->getAccount();
		//var_dump($this->account);
	}
	// Login Page
	public function index()
	{
		$title= 'Login';
		$this->load->view('clients/login', compact('title'));
	}
	// Check Login
	public function login()
	{
		$error = NULL;

		$email = $this->input->post('email');
		$password = $this->input->post('password');
		
		if ($this->input->post()) {
			// try to log user in	
			if ($this->auth->login($email, $password)) {
				$redirect_url = '/clients/welcome';
				redirect($redirect_url);
			}
			else {
				$error = '<div class="alert alert-danger">Account details incorrect</div>';
				$logged_out = '<div class="alert alert-success"><strong>Success: </strong> You\'ve been logged out</div>';
			}
		}
		$title = 'Login';
		$this->load->view('clients/login', compact('error','logged_out','title'));
	}
	// logout
	public function logout()
	{
		$this->auth->logout();
		$this->session->set_flashdata('logged_out','You\'ve been sucessfully logged out');
		redirect('/clients/login');
	}
	// Clients welcome/dashboard page
	public function welcome()
	{
		if ($this->auth->is_logged_in() === false) { $this->session->set_flashdata('error','You must be logged in to continue'); redirect('clients/login', 'refresh'); }
		$title = 'Welcome';
		$this->load->view('clients/welcome', compact('title'));
		
	}
	// generic informational page
	function upgrade_benefits()
	{
		$this->load->view('clients/upgrade_benefits');
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
				$this->email->from('info@clockinpoint.com', 'Clock in Point');
				$this->email->to($this->account->user->email);
				$this->email->subject('Subscription Confirmation');
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
		$this->load->view('account/change_package', compact('error','account'));	
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
		
		$this->load->view('account/package_changed', compact('old_subscription','new_subscription','account'));
		
	}
	// Create an account
	public function create_account()
	{
		$error = false;
		$account = R::dispense('account');
		$user = R::dispense('user');
		$address = R::dispense('address');		
		$countries = R::findAll('country', 'ORDER BY name');
		
		if ($data = $this->input->post()) {
			
			try {
				
				$user->import($data, 'title,first_name,last_name,tel,email,password');
				$account->import($data, 'company_name,business_type,type');
				$address->import($data['address'], 'line_1,line_2,city,postcode,country_id');

				// Set errors/messages	
				if ($data['email'] != $data['email2']) throw new Exception('Emails must match');
				if ($data['password'] != $data['password2']) throw new Exception('Passwords must match');
				if (empty($data['agree_to_terms'])) throw new Exception('Agreement to our Terms is required');
				if (empty($data['first_name'])) throw new Exception('First Name is required');
				if (empty($data['last_name'])) throw new Exception('Last Name is required');
				if (empty($data['tel'])) throw new Exception('Telephone number is required');
				//if (empty($data['company_name'])) throw new Exception('Company Name is required');
				if (empty($data['address'])) throw new Exception('Address is required');
				
				
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
				$this->email->from('info@clockinpoint.com', 'Clock in Point');
				$this->email->to($user->email);		
				$this->email->subject('Registration Confirmation - Clock In Point');
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
			$title = 'Create Account';
			$this->load->view('clients/create_account', compact('user','account','countries','address','error','data','title'));

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
				$this->email->from('info@clockinpoint.com', 'Clock in Point');
				$this->email->to($user->email);				
				$this->email->subject('Clockin Point - Password Reset');
				$this->email->message($message);
				$this->email->send();
				// dev only: $this->email->print_debugger();
				redirect('/account/forgot_password_complete');
			}
		}
		$title = 'Forgot Password';
		$this->load->view('account/forgot_password', compact('error','data','title'));	
	}
	
	function forgot_password_complete()
	{
		$title = 'Password Resent';
		$this->load->view('account/forgot_password_complete', compact('title'));	
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
	function add()
	{
		$this->auth->action('add','client');
		$error = false;
		$data['account_number'] = '';
		
		if ($data = $this->input->post()) {
			
			try {
				
				// some minor validation
				if (strlen($data['account_number']) != 8) throw new Exception('Account Numbers are always 8 digits long');
				
				// search for this account number
				$client = R::findOne('account', 'account_number = ?', array($data['account_number']));
				
				if (!$client) throw new Exception('No user was found with that Account Number');
				
				// establish the new relationship (but not approved yet)
				list($client_party, $provider_party) = R::dispense('party', 2);
				$client_party->account = $client;
				$provider_party->account = $this->account;
				
				$client_party->active = 1;
				$client_party->role = 'client';
				$provider_party->active = 1;
				$provider_party->role = 'provider';
				
				$contract = R::dispense('contract');
				$contract->approved = 0;
				$contract->ownParty = array($client_party, $provider_party);
				$contract_id = R::store($contract);
				
				// send email to client
				$this->load->library('encrypt');
				$key = $this->encrypt->encode($contract_id);
				$key = base64_url_encode($key);
				
				$message = 'A provider called <i>' . 
					$this->user->username . 
					'</i> wants to list you as a client. You can either <a href="' . 
					site_url('/clients/approve/'. $key) . 
					'">Approve</a> or <a href="' . 
					site_url('/clients/reject/'. $key) . 
					'">Reject</a> this request.'
					;
				$this->load->library('email');
				$this->email->from('info@clockinpoint.com', 'Clock in Point');
				$this->email->to($client->email());
				//$this->email->bcc('andycoatz@gmail.com');				
				$this->email->subject('Provider Approval Request');
				$this->email->message($message);
				$this->email->send();
				
				
				$this->session->set_flashdata('message', 'Client added successfully. An email has been sent to them for approval.');
				redirect('/clients');
			} catch (Exception $e) {
				$error = $e->getMessage();
			}
		}
		$title ='Add new client';
		$this->load->view('clients/add', compact('error','data','title'));
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
				
				$account->import($data, 'company_name,business_type,show_clients,show_devices,custom_1_name,custom_2_name');
				$address->import($data['address'], 'line_1,line_2,city,postcode,country_id');
				
				if (!isset($data['show_clients'])) $account->show_clients = 0;
				if (!isset($data['show_devices'])) $account->show_devices = 0;
				
				R::store($account);
				//R::store($address);
				
				$this->session->set_flashdata('message', 'Account details successfully updated');
				redirect('/account/welcome');
			} catch (Exception $e) {
				$error = $e->getMessage();
			}
		}
		
		$this->load->view('account/edit', compact('account','countries','address','error','card'));
	}
	
	function edit_payment_details()
	{
		$this->auth->action('edit_payment_details', 'account');
		$countries = R::find('country', '1 ORDER BY name');
		$this->load->view('account/edit_payment_details', compact('countries'));
	}
	// Send to friend request from within the customer area, welcome screen!
	function send_to_friend()
	{
		$this->form_validation->set_rules('friend_email','Friends Email','valid_email|trim');
		$this->form_validation->set_rules('your_email','Your Email','valid_email|trim');
		$this->form_validation->set_rules('comments','Comments','trim');

		if ($this->form_validation->run() == FALSE) {
			validation_errors();
		}
		else {
			$this->load->library('email');
			$config['charset'] = 'utf-8';
			$config['mailtype'] = 'html';

			$email = $this->input->post('your_email');
			$friend_email = $this->input->post('friend_email');
			$friend_name = $this->input->post('friend_name');
			$my_name = $this->input->post('your_name');

			$lg = '<img src="'.site_url().'images/logo-mpdf.png">';
			
			$message = ''.$lg.'<br /><br />
					Hi '.$friend_name.',<br />
					Your friend '.$my_name.' has sent you this request to take a look at <a href="http://www.clockinpoint.com">Clock in Point</a><br />

					<br />
					Sent by Clock in Point at '.date('j F Y H:i').'
			';

			$this->email->initialize($config);
			$this->email->from($email);
			$this->email->to($friend_email);		
			$this->email->subject($friend_name .' ');
			$this->email->message($message);
			$this->email->send();

		}
		// Javascript to show alert that the message has been sent - used for ease and simplicity
		echo '<script type="text/javascript">
			    alert("Thank You,\r\nYou message has been sent to '.$friend_name.' at '.$friend_email.'");
			    location = "welcome";
			 </script>';

	}

	
}

/* End of file clients.php */
