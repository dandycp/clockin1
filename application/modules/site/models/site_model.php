<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site_model extends CI_Model {

	//  Auth for partners login
	public function auth($email, $password) 
	{
		$CI =& get_instance();
		
		$CI->db->where('email', $email);
		$CI->db->where('password', sha1($password));

		$query = $CI->db->get('partners');

		if ($query->num_rows())
		{
			$user = $query->row();
			
			$session_data = array(
				 'status'	 		=> $user->status,
				 'user_id'	   	    => $user->id,
		         'name'             => $user->name,
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
			$CI->db->update('partners', $data);

			return TRUE;
			
		}

		return FALSE;
	}


}

/* End of file site_model.php */
/* Location: ./application/models/site_model.php */