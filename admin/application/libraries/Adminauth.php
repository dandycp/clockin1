<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Authorisation Class
* @package auth class for authentication of site
* 
*/
class Adminauth
{
  	protected $CI;

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
	// Login
	public function login($email, $password) 
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
		$CI->db->delete('sessions');
		$CI->session->unset_userdata('user_id');	
		$CI->session->set_flashdata('logged_in','You\'ve been sucessfully logged out');
	}

	

}

/* End of file Admin.php */
/* Location: ./application/libraries/Admin.php */
