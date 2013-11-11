<?php 

class Model_Account extends MY_Bean
{
	
	public function name()
	{
		return (!empty($this->company_name)) ? 
			$this->company_name : 
			$this->user->first_name . ' ' . $this->user->last_name;	
	}
	
	public function contact_name()
	{
		return $this->user->first_name . ' ' . $this->user->last_name;
	}
	
	public function tel()
	{
		return $this->user->tel;
	}
	
	public function email()
	{
		return $this->user->email;
	}
	
	public function update()
	{
		$CI =& get_instance();
		$CI->load->library('encryption');
		
		if (empty($this->type)) throw new Exception('Account Type is required');
		//if (empty($this->company_name)) throw new Exception('Company Name is required');
		if (empty($this->account_number)) $this->account_number = $this->generate_account_number();
		if (empty($this->secret_key)) $this->secret_key = $CI->encryption->createRandomKey();	
	}
	
	
	// generate an 8 digit reference code for this user
	public function generate_account_number()
	{
		$current_highest_id = R::getCell("SELECT id FROM account ORDER BY id DESC LIMIT 1");
		$our_id = $current_highest_id + 1;
		$account_number = str_pad($our_id, 4, '0', STR_PAD_RIGHT);
		$rand = mt_rand(1,9999);
		$account_number.= str_pad($rand, 4, '0', STR_PAD_LEFT);
		return $account_number;
	}
	
	// get all users that are related by being clients of our user
	public function get_clients($only_approved=false)
	{
		$clients = array();
		// get all the current contracts in place
		$contracts = $this->get_provider_contracts($only_approved);
		
		if (!empty($contracts)) foreach ($contracts as $contract) {
			$client = $contract->client;
			$clients[$client->id] = $client; // make sure we're not returning duplicates
		}
		
		$clients = array_values($clients);

		return $clients;
	}
	
	// get all users that are related by being clients of our user
	public function get_providers($only_approved=false)
	{
		$providers = array();
		// get all the current contracts in place
		$contracts = $this->get_client_contracts($only_approved);
		
		if (!empty($contracts)) foreach ($contracts as $contract) {
			$provider = $contract->provider;
			$providers[$provider->id] = $provider; // make sure we're not returning duplicates
		}
		
		$providers = array_values($providers);

		return $providers;
	}
	
	public function get_card()
	{
		$card = R::findOne('card', 'account_id = ? ORDER BY added_at DESC', array($this->id));
		return (!empty($card)) ? $card : false ;
	}
	
	// gets all contracts where this uesr is the client
	public function get_client_contracts($only_approved=false)
	{
		$contracts = array();
		// get all the times this user has become a 'party' to a contract
		$parties = $this->bean->withCondition("role='client' AND active=1")->ownParty;
		if ($parties) foreach ($parties as $party) {
			$contract = $party->contract;
			if (!$only_approved || $contract->approved == 1) {
				$provider = reset($contract->withCondition("role='provider'")->ownParty)->account;
				$contract->provider = $provider; // a temporary convenience property
				$contracts[] = $contract;
			}
		}
		return $contracts;
	}
	
	// gets all contracts where this uesr is the provider
	public function get_provider_contracts($only_approved=false)
	{
		$contracts = array();
		// get all the times this user has become a 'party' to a contract
		$parties = $this->bean->withCondition("role='provider' AND active=1")->ownParty;
		if ($parties) foreach ($parties as $party) {
			$contract = $party->contract;
			if (!$only_approved || $contract->approved == 1) {
				$client = reset($contract->withCondition("role='client'")->ownParty)->account;
				$contract->client = $client; // a temporary convenience property
				$contracts[] = $contract;
			}
		}
		return $contracts;
	}
	
	// get all the categories set up for this account (boiler service, security check, etc)
	public function get_categories()
	{
		$categories = $this->bean->withCondition('active = 1 ORDER BY name')->ownCategory;
		return $categories;
	}
	
	// get all people associated with this account (usually staff)
	public function get_people()
	{
		$people = $this->bean->withCondition('active = 1 ORDER BY name')->ownPerson;
		return $people;
	}
	
	
	
	public function has_clients()
	{
		$clients = $this->get_clients(true);
		return (!empty($clients)) ? true : false ;
	}
	
	public function has_devices()
	{
		$devices = $this->bean->ownDevice;
		return (!empty($devices)) ? true : false ;
	}
	
	public function has_valid_payment_details()
	{
		if (!$card = $this->get_card()) return false;
		if ($card->has_expired()) return false;
		return true;
	}
	
	// decide whether to display custom field 1 for code entries
	public function uses_custom_1()
	{
		return (!empty($this->custom_1_name));
	}
	
	// decide whether to display custom field 1 for code entries
	public function uses_custom_2()
	{
		return (!empty($this->custom_2_name));
	}
	
	// get the currently active subscription
	public function subscription()
	{
		$item = R::findOne('subscription', "account_id = ? AND active=1 ORDER BY id DESC", array($this->bean->id));
		if (!$item) $item = R::dispense('subscription');
		return $item;
	}
	
}