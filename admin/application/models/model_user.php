<?php 

class Model_user extends MY_Bean 
{
	public function open()
	{
		$this->add_aliases();
	}
	
	private function add_aliases()
	{
		$this->name = $this->first_name . ' ' . $this->last_name;
		$this->username = (!empty($this->company_name)) ?
			$this->company_name :
			$this->first_name . ' ' . $this->last_name;
	}
	
	private function remove_aliases()
	{
		unset($this->bean->name, $this->bean->username);
	}
	
	// called every time the user is about to be updated/saved
	public function update() 
	{	
		$CI =& get_instance();
		$CI->load->helper('email');
		
		if (empty($this->first_name)) throw new Exception('First Name is required');
		if (empty($this->last_name)) throw new Exception('Last Name is required');
		if (empty($this->tel)) throw new Exception('Telephone number is required');
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
		
		$this->remove_aliases();
		
		// hash the password
		if ($this->bean->hasChanged('password')) {
			require dirname(__FILE__) . '/../libraries/PasswordHash.php';
			$hasher = new PasswordHash(8, false);
			$this->password = $hasher->HashPassword($this->password);
		}		
	}
	
	public function after_update()
	{
		$this->add_aliases();	
	}
	
	
	// get the top level account associate with this user
	// in a company, this would be the main admin user
	public function get_owner()
	{
		$user = $this->bean->account->user;
		return $user;
	}
	
	// get all the users that exist in a usergroup created by this user
	// todo - make sure that users can't create a user without creating a usergroup first
	public function get_subusers()
	{
		$usergroups = R::find('usergroup', 'user_id = ?', array($this->id));
		$subusers = array();
		
		if (!empty($usergroups)) {
			
			foreach ($usergroups as $usergroup) {
				$users = $usergroup->ownUser;
				if (!empty($users)) {
					array_push($subusers, $users);	
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
	
	// checks to see if this users is an admin user
	public function is_admin()
	{
		$account = $this->account;
		if (!$account) return false;
		$owner = $account->user;
		$account_owner_id = $owner->id;
		$our_id = $this->id;
		return ($our_id == $account_owner_id) ? true : false ;	
	}
	
	// check this is a special 'super' user
	public function is_super()
	{
		return ($this->bean->super) ? true : false ;
	}

}