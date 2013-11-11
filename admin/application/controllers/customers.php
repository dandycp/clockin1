<?php 

class Customers extends MY_Controller
{

	function index()
	{
		$title = 'My Clients';
		$this->auth->action('list', 'client');
		$contracts = $this->account->get_provider_contracts();
		$this->load->view('customers/list', compact('contracts','title'));
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
					site_url('/customers/approve/'. $key) . 
					'">Approve</a> or <a href="' . 
					site_url('/customers/reject/'. $key) . 
					'">Reject</a> this request.'
					;
				$this->load->library('email');
				$this->email->from('info@clockinpoint.com', 'Clock in Point');
				$this->email->to($client->email());			
				$this->email->subject('Provider Approval Request');
				$this->email->message($message);
				$this->email->send();
				
				
				$this->session->set_flashdata('message', 'Client added successfully. An email has been sent to them for approval.');
				redirect('/customers');
			} catch (Exception $e) {
				$error = $e->getMessage();
			}
		}
		$title = 'Add New Client';
		$this->load->view('customers/add', compact('error','data','title'));
	}
	
	
	// this is typically a link clicked from an email by a client
	// $key should be in an encrypted form of contract_id
	function approve($key)
	{
		$this->auth->action('approve', 'client');
		
		$this->load->library('encrypt');
		$key = base64_url_decode($key);
		$id = $this->encrypt->decode($key);
		
		$contract = R::load('contract', $id);
		if (!$contract) die('This relationship was not found');
		$contract->approved = 1;
		R::store($contract);
		$this->show_message('Client Approval', 'Client successfully approved!');
		
	}
	
	
	// this is typically a link clicked from an email by a client
	function reject($key)
	{
		$this->auth->action('reject', 'client');
		$this->load->library('encrypt');
		$key = base64_url_decode($key);
		$id = $this->encrypt->decode($key);
		
		$contract = R::load('contract', $id);
		if (!$contract) die('This relationship was not found');
		$contract->approved = 0;
		R::store($contract);
		$this->show_message('Client Approval', 'Client was rejected');	
	}
	
	function delete($id=false)
	{
		$this->auth->action('delete', 'client');
		if (!$id) redirect('/customers');
		$contract = R::load('contract', $id);
		if (!$contract->id) show_404();
		$client = $contract->get_client();
		$provider = $contract->get_provider();
		
		// check for safety that this provider is our user!
		if ($provider->id != $this->account->id) show_404();
		
		if ($data = $this->input->post()) {
			
			// we don't want to actually delete the contract in case it needs to be referred to in the future
			// so just set this party as inactive
			$provider_party = $contract->get_provider_party();
			$provider_party->active = 0;
			R::store($provider_party);
			$this->session->set_flashdata('message', 'Client successfully deleted');
			redirect('/customers');
		}
		$title = 'Delete Client';
		$this->load->view('customers/delete', compact('client','title'));
	}


}