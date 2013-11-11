<?php 

class MY_Bean extends RedBean_SimpleModel 
{
	
	// provices an indexed alternative to RedBean's own "->ownObject" method
	public function own($object) 
	{
		$method = 'own' . ucfirst($object);
		$children = array_values($this->{$method});
		return $children;
	}
}

class Model_Address extends MY_Bean 
{
	public function dispense()
	{
		// set default country to UK
		$this->country_id = 222;
	}
	
	public function full_address()
	{
		$parts = array_filter(array($this->line_1, $this->line_2, $this->city));
		$joined = implode(', ', $parts);
		return $joined;
	}
	
	public function update() 
	{
		//if (empty($this->location)) throw new Exception('Location is required');	
	}
}

class Model_Code extends MY_Bean 
{
	public function update() 
	{
		if (empty($this->code)) throw new Exception('Code is required');
		elseif (strlen($this->code) != 8) throw new Exception('Code must be 8 characters in length');
		if (empty($this->type)) throw new Exception('Type is required');
		if (!preg_match('/[a-z0-O]{8}/i', $this->code)) throw new Exception('Only characters A-Z and 0-9 allowed');
		$this->code = strtoupper($this->code);
		
		// calculate duration for where there is a start and end code
		if (!empty($this->end_time)) {
			$t1 = new DateTime($this->time);
			$t2 = new DateTime($this->end_time);
			$seconds = $t2->getTimestamp() - $t1->getTimestamp();
			$this->duration = $seconds;
		} else {
			$this->duration = 0;	
		}
	}
	
	public function format_time($format)
	{
		return date($format, strtotime($this->time));	
	}
}

class Model_Contract extends MY_Bean
{
	public function update()
	{
		$this->bean->updated_at = NULL;	
	}
	public function get_client()
	{
		$client = false;
		$party = $this->get_client_party();		
		if ($party) $client = $party->user;
		return $client;
	}
	
	public function get_provider()
	{
		$provider = false;
		$party = $this->get_provider_party();
		if ($party) $provider = $party->user;
		return $provider;
	}
	
	public function get_client_party()
	{
		$party = reset($this->bean->withCondition("role='client'")->ownParty);
		return $party;
	}
	
	public function get_provider_party()
	{
		$party = reset($this->bean->withCondition("role='provider'")->ownParty);
		return $party;
	}
}

class Model_Device extends MY_Bean 
{	
	public function open()
	{
	}
	
	public function update() 
	{
		if (empty($this->location)) throw new Exception('Location is required');	
	}
}

class Model_User extends MY_Bean 
{
	
	public function contact_name()
	{
		return trim($this->first_name . ' ' . $this->last_name);	
	}
	
	// get the top level account associate with this user
	// in a company, this would be the main admin user
	public function get_owner()
	{
		$user = clone $this->bean;
		
		while ($user->user_id) {
			$user = R::load('user', $user->user_id);	
		}
		
		return $user;
	}
	
	public function get_subusers()
	{
		$user_id = $this->id;
		
		$subusers = R::find('user', 'user_id = ?', array($user_id));
		
		if (!empty($subusers)) {
			
			foreach ($subusers as $user) {
				$subsubusers = $user->get_subusers();
				if (!empty($subsubusers)) {
					$subusers = array_merge($subusers, $subsubusers);	
				}
			}
		}
		
		return $subusers;
	}
	
	// get any users that are owned by this user
	public function get_subuser_ids()
	{
		$user_ids = array();
		$users = $this->get_subusers();
		
		if ($users) {
			foreach ($users as $user) {
				//echo '<pre>'; var_dump($user);
				$user_ids[] = $user->id;
			}
		}
		return $user_ids;
	}
	
	public function update() 
	{
		
		$CI =& get_instance();
		$CI->load->helper('email');
		$CI->load->library('encryption');
		
		if (empty($this->first_name)) throw new Exception('First Name is required');
		if (empty($this->last_name)) throw new Exception('Last Name is required');
		if (empty($this->type)) throw new Exception('User Type is required');
		if ($this->type == 'provider' && empty($this->company_name)) throw new Exception('Company Name is required');
		if (empty($this->email)) throw new Exception('Email is required');
		if (!valid_email($this->email)) throw new Exception('Email is not valid');
		if (empty($this->password)) throw new Exception('Password is required');
		if (empty($this->usergroup_id)) throw new Exception('User Group is required');
		
		// if this is a new bean, make sure email doesn't already exist
		if (!$this->bean->id) {
			$email = $this->email;
			$existing_user = R::findOne('user', 'email=?', array($email));
			if ($existing_user) throw new Exception('This email address is already in use by another account');
		}
		
		if (empty($this->account_number)) $this->account_number = $this->generate_account_number();
		if (empty($this->secret_key)) $this->secret_key = $CI->encryption->createRandomKey();
	}
	
	public function user_name()
	{
		if (!empty($this->company_name)) return $this->company_name;
		else return $this->first_name . ' ' . $this->last_name;
	}
	
	// generate an 8 digit reference code for this user
	public function generate_account_number()
	{
		$current_highest_id = R::getCell("SELECT id FROM user ORDER BY id DESC LIMIT 1");
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
		// get all the occasions this user has the role of client
		$parties = $this->bean->withCondition("role='client'")->ownParty;
		foreach ($parties as $party) {
			$other_party = reset($party->contract->withCondition("role='provider'")->ownParty);
			$providers[] = $other_party->user;
		}

		return $providers;
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
				$provider = reset($contract->withCondition("role='provider'")->ownParty)->user;
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
				$client = reset($contract->withCondition("role='client'")->ownParty)->user;
				$contract->client = $client; // a temporary convenience property
				$contracts[] = $contract;
			}
		}
		return $contracts;
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

}

class Model_Usergroup extends MY_Bean 
{
	public function update() 
	{
		if (empty($this->name)) throw new Exception('Name is required');
		if (empty($this->user_id)) throw new Exception('User/Owner is required');
	}
	
	public function get_actions()
	{
		$actions = array();
		$permissions = $this->ownPermission;
		if ($permissions) foreach ($permissions as $permission) {
			$entity = $permission->entity;
			$action = $permission->action;
			$actions[$entity->id][] = $action;
		}
		return $actions;
	}
	
	public function get_entities()
	{
		$entities = array();
		$permissions = $this->ownPermission;
		if ($permissions) foreach ($permissions as $permission) {
			$entity = $permission->entity;
			if (!in_array($entity->id, $entities))
				$entities[$entity->id] = $entity;
		}
		return $entities;
	}
	
	public function get_permissions()
	{
		$permissions_array = array();
		$permissions = $this->ownPermission;
		if ($permissions) foreach ($permissions as $permission) {
			$entity = $permission->entity;
			$action = $permission->action;
			$permissions_array[$entity->id][$action->id] = $action->id;
		}
		return $permissions_array;
	}
}