<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class User_model extends CI_Model {
	
	
	public function auth($username, $password)
	{
		$this->db->where('username', $username);
		$this->db->where('password', sha1($password));

		$query = $this->db->get('admins');

		if ($query->num_rows())
		{
			$user = $query->row();
			
			$session_data = array(
				'status'	   => $user->status,
				'user_id'	   => $user->id,
				'username'     => $user->username,
		        'first_name'   => $user->first_name,
		        'is_admin'     => true,
		        'is_logged_in' => true,
		        'last_login'   => time()
			);

			$this->session->set_userdata($session_data);
			// var_dump($session_data);
			return TRUE;
		}

		return FALSE;
	}
	public function getUser()
	{
		$user_id = $this->session->userdata('user_id');

		
	}



}