<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Authorisation Class
* @package auth class for authentication of site
* 
*/
class Auth
{
  	protected $CI;
  	public function action($action_name, $entity_ref)
	{
		// check they're actually logged in for starters
		$logged_in = $this->is_logged_in();
		
		// send off to the login page if not
		$CI =& get_instance();
		$CI->session->set_userdata('redirect_url', current_url());
		if (!$logged_in) redirect('/clients/login');
		
		// get their user/group information
		$user_id = $this->get_user_id();
		$user = R::load('user', $user_id);
		
		// skip further checks if they are a 'super' user
		if ($user->is_super()) return true;
		
		// find out if there is a permission set for them
		$query = "
			SELECT * FROM permission AS p
			INNER JOIN action AS a ON p.action_id = a.id
			INNER JOIN entity AS e ON a.entity_id = e.id 
			WHERE a.name = ? 
			AND e.ref = ? 
			AND p.usergroup_id = ?
			LIMIT 1 
		";
		$result = $CI->db->query($query, array($action_name, $entity_ref, $user->usergroup->id))->result();
		
		if (!$result) $this->access_restricted();
		
	}
	public function get_user_id()
	{
		$CI =& get_instance();
		$user_id = $CI->session->userdata('user_id');
		return $user_id;
	}
	// Is the user logged in ?
	public function is_logged_in()
	{
		$user_id = $this->get_user_id();
		return ($user_id > 0) ? true : false ;
	}
	// Login uses salt hashing (NOT USED)
	public function login($email, $password)
	{
		$CI =& get_instance();
		
		$user = R::findOne('user','email = ?', array($email));
		if (!$user) return false;
		
		// check password
		require dirname(__FILE__) . '/PasswordHash.php';
		$hasher = new PasswordHash(8, false);
		if (!$hasher->CheckPassword($password, $user->password)) return false;
		
		$CI->session->set_userdata('user_id', $user->id);
		$userdata = $CI->session->all_userdata();
				
		$user->last_login = date("Y-m-d H:i:s");
		$user->session_id = $userdata['session_id'];

		$session_data = array(
				 'status'	 		=> $user->status,
				 'user_id'	   	    => $user->id,
				 'username'       	=> $user->username,
		         'first_name'       => $user->first_name,
		         'account_id'		=> $user->account_id,
		    
		         'is_logged_in' 	=> true,
		         'last_login'   	=> date("Y-m-d H:i:s")
			);
			$CI->session->set_userdata($session_data);
		R::store($user);
		return true;
	}
	public function __login($email, $password) 
	{
		$CI =& get_instance();
		
		$CI->db->where('email', $email);
		$CI->db->where('password', sha1($password));

		$query = $CI->db->get('user');

		if ($query->num_rows())
		{
			$user = $query->row();
			
			$session_data = array(
				 'status'	 		=> $user->status,
				 'user_id'	   	    => $user->id,
				 'username'       	=> $user->username,
		         'first_name'       => $user->first_name,
		         'account_id'		=> $user->account_id,
		    
		         'is_logged_in' 	=> true,
		         'last_login'   	=> date("Y-m-d H:i:s")
			);
			$CI->session->set_userdata($session_data);
						
			$data = array(
               'last_login' => $CI->session->userdata('last_login'),
               'session_id' => $CI->session->userdata('session_id')
            );
			$CI->db->where('id', $user->id);
			$CI->db->update('user', $data);

			return TRUE;
			
		}

		return FALSE;
	}
	
	// Logout
	public function logout()
	{
		$CI =& get_instance();
		// Unsets session and destroys but for added stability and speed remove the session completly from the database
		$CI->db->where('session_id', $CI->session->userdata('session_id'));
		$CI->db->delete('session');
		$CI->session->unset_userdata('user_id');	
		$CI->session->set_flashdata('logged_out','You\'ve been sucessfully logged out');
	}
	public function access_restricted($message="You don't have the necessary permissions to do this!")
	{
		echo 'Access Denied';
	}

	

}

/* End of file Auth.php */
/* Location: ./application/libraries/Auth.php */
