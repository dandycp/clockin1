<?php 

class Providers extends MY_Controller
{

	function index()
	{
		//$this->auth->action('list','provider');
		if (isset($this->account->type) && $this->account->type != 'pro') redirect('/');
		// todo - check permissions to do this
		//$this->auth->action('list', 'providers');
		$contracts = $this->account->get_client_contracts();
		$title = 'My Providers';
		$this->load->view('providers/list', compact('contracts','title'));
	}

	function add()
	{
		$this->auth->action('add', 'provider');
		$error = false;
		$data['account_number'] = '';
		$my_account = $this->account->account_number;

		if ($data = $this->input->post()) {
			
			try {
				
				// some minor validation
				if (strlen($data['account_number']) != 8) throw new Exception('Account Numbers are always 8 digits long');
				
				// search for this account number
				$client = R::findOne('account', 'account_number = ?', array($data['account_number']));
				
				if (!$client) throw new Exception('No user was found with that Account Number');
				if ($my_account === $data['account_number']) throw new Exception('Sorry! You cannot add yourself to the provider list');
				// Need some more validation for checking if the request as already taken place and sends notification to the user.
			
				
				// establish the new relationship (but not approved yet)
				list($client_party, $provider_party) = R::dispense('party', 2);
				$client_party->account = $client;
				$provider_party->account = $this->account;
				
				$client_party->active = 1;
				$client_party->role = 'client';
				$provider_party->active = 1;
				$provider_party->role = 'provider';
				
				$contract = R::dispense('contract');
				$contract->approved = 1;
				$contract->ownParty = array($client_party, $provider_party);
				$contract_id = R::store($contract);
				
				// send email to client
				$this->load->library('encrypt');
				$key = $this->encrypt->encode($contract_id);
				$key = base64_url_encode($key);
				
				$message = '<img src="'.site_url().'/images/logo-mpdf.png"><br />
				Hi,<br />

				A provider called <i>' . 
					$this->user->username . 
					'</i> wants to list you as a client. You can either <a href="' . 
					site_url('/clients/providers/approve/'. $key) . 
					'">Approve</a> or <a href="' . 
					site_url('/clients/providers/reject/'. $key) . 
					'">Reject</a> this request.<br /><br />Regards,<br />ClockinPoint'
					;
				$this->load->library('email');
				$config['charset'] = 'utf-8';
				$config['mailtype'] = 'html';

				$this->email->initialize($config);

				$this->email->from('info@clockinpoint.com', 'Clock in Point');
				$this->email->to($client->email());			
				$this->email->subject('Provider Approval Request');
				$this->email->message($message);
				$this->email->send();
				
				
				$this->session->set_flashdata('message', 'Provider request successful, an email has been sent to them for approval.');
				redirect('/providers');
			} catch (Exception $e) {
				$error = $e->getMessage();
			}
		}

		
		$title = 'Add Provider';
		$this->load->view('providers/add', compact('title','error','data','client','provider'));

		
	}
	
	function approve($id)
	{
		$this->auth->action('approve', 'provider');
		$contract = R::load('contract', $id);
		if (!$contract) show_404();
		
		$client = $contract->get_client();
		if ($client->id != $this->account->id) $this->auth->access_restricted();
		
		$contract->approved = 1;
		R::store($contract);
		$data['title'] = 'Provider Approved';
		$this->session->set_flashdata('message', 'Provider successfully approved!');
		redirect('/providers', $data);
		
	}
	function edit($id)
	{
		$this->auth->action('edit', 'provider');
		$this->load->library('form_validation');
		$id = $this->uri->segment(4);

		/*
		$rate = $this->hour_rate;
		$existing = R::findOne('account', 'hour_rate=?', array($rate));
		if ($existing > $existing) throw new Exception('More than');
		if ($existing < $existing) throw new Exception('Less then');
		*/

		$client = $this->client_m->get_account_by_number($id);
		$provider = $this->client_m->get_user_info();

		$this->form_validation->set_rules('hour_rate','Expected Rate','required');
		$this->form_validation->set_rules('tolerance_rate','Tolerence Rate is wrong','required|is_numeric');

		if ($this->form_validation->run() == FALSE){
			$errors = validation_errors();
		}
		else {
			// Send updates to the database
			$this->client_m->update_provider($id);
			$this->session->set_flashdata('message', 'Provider details updated successfully.');
		}
		
		$title = 'Edit Provider';

		$this->load->view('providers/edit', compact('title','contract','client','provider','errors'));
	}
	
	
	function delete($id=false)
	{
		$this->auth->action('delete', 'provider');
		if (!$id) redirect('/providers');
		$contract = R::load('contract', $id);
		if (!$contract) show_404();
		$client = $contract->get_client();
		$provider = $contract->get_provider();
		
		// check for safety that this provider is our user!
		if ($client->id != $this->account->id) show_404();
		
		if ($data = $this->input->post()) {
			
			// we don't want to actually delete the contract in case it needs to be referred to in the future
			// so just set this party as inactive
			$client_party = $contract->get_client_party();
			$client_party->active = 0;
			R::store($client_party);
			
			// unapprove the contract as well
			$contract->approved = 0;
			R::store($contract);
			
			$this->session->set_flashdata('message', 'Provider successfully deleted');
			redirect('/providers');
		}
		$title = 'Delete Provider';
		$this->load->view('providers/delete', compact('provider','title'));
	}
	// Send email to user entered in 'add provider'
	function send_email()
	{
		// Email the user
		$config['mailtype'] = 'html';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;

		$this->email->initialize($config);


		// All fields for email		
		$email = $this->input->post('customer_email');
		$today = date('j F Y H:i');
		$logo  = base_url().'images/logo-mpdf.png';
		
		$message = "<img src='$logo' /><br /><br />
					Hello <br />
					We have been using Clockinpoint blah blah blah, need some content for this email<br />
					<strong>Generated by Clock In Point - $today </strong>
					<br />
					<strong>www.clockinpoint.com</strong>
					";
			
		
		$this->email->from('info@clockinpoint.com');
		$this->email->to($email);
		$this->email->subject('Clock In Point');
				
		$this->email->message($message);
		
		$this->email->send(); // Send the message function to the persons email address
		$this->email->clear(); // Clears the form ready for another submission
		
		$this->session->set_flashdata('message','Email successfully sent to <strong>'.$email.'</strong>');
		redirect('providers/index');
	}


}