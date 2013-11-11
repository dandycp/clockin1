<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Check_model extends CI_Model {

	
	function batch_ref()
	{
		$this->load->database();
		$result = $this->db->query("SELECT MAX(id)+1 AS 'num' FROM code")->row_array();
		$input = $result['num'];
		$output = 'U';
		
		// base 30! (commonly confused letters/number have been removed, including 'E' which can cause problems with scientific notation)
		$index = array('2','3','4','5','6','7','8','9','A','B','C','D','F','G','H','J','K','M','N','P','Q','R','S','T','U','V','W','X','Y','Z');
		
		$base = count($index);
	
		$converted = base_convert($input, 10, $base);
		
		$ref = '';
		// now loop through the new base 30 string and convert to using our preferred characters only
		for ($i=0; $i<strlen($converted); $i++) {
		 $char = substr($converted, $i, 1);
		 $pos = base_convert($char, $base, 10);
		 $newchar = $index[$pos];
		 $ref.= $newchar;
		}
		
		// now pad this to 5 chars min
		// should be safe (avoid collisions) padding with "1" as we're not using this in our index array
		$padded = str_pad($ref, '5', '1', STR_PAD_LEFT);
		
		$output.= $padded;
		
		// generate a 2 digit random num to add to the end to decrease chance of collision if bookings made in same milisecond
		// for instance if our database returned the same max orderID
		shuffle($index);
		$rand_num = $index[0] . $index[1];
		
		$output .= $rand_num;
		
		return $output;
	
	}
	function codeUpdate($code='')
	{
		$code = $this->input->post('single');
		$inputter_id = $this->session->userdata('user_id');
		$device_id = $this->session->userdata('uri');
		$account_id = $this->session->userdata('account_id');
		$user_offset = $this->input->post('user_offset');
		$ip = $this->input->ip_address();
		$timestamp = date('Y-m-d G:i:s');

		// Gets all $vars and stores to the database
		$data = array(
		   'code' 			=> strtoupper($code),
		   'type' 			=> 'single',
		   'time' 			=> $timestamp,
		   'duration' 		=> 10,
		   'batch_ref' 		=> $this->batch_ref(),
		   'added_at' 		=> $user_offset,
		   'inputter_id' 	=> $inputter_id,
		   'device_id' 		=> $device_id,
		   'account_id'		=> $account_id,
		   'inputter_ip'	=> $ip
		);

		$this->db->insert('code', $data); 
	}
	function temp_save()
	{
		$code = $this->input->post('single');
		$inputter_id = $this->session->userdata('user_id');
		$device_id = $this->uri->segment(4);
		$account_id = $this->session->userdata('account_id');
		$user_offset = $this->input->post('user_offset');
		$ip = $this->input->ip_address();
		$timestamp = date('Y-m-d G:i:s');

		// Gets all $vars and stores to the database
		$data = array(
		   'temp_code' 		=> strtoupper($code),
		   'type' 			=> 'single',
		   'inputter_id' 	=> $inputter_id,
		   'device_id' 		=> $device_id,
		   'account_id'		=> $account_id,
		   'inputter_ip'	=> $ip,
		   'code' 		    => strtoupper($code)
		);

		$this->db->insert('code', $data); 
		$this->session->set_userdata('temp_code', strtoupper($code));
		$this->session->set_userdata('temp_device_id', $device_id);
		$this->session->set_userdata('temp_account_id', $account_id);

	}
	function check_code($code ='')
	{
		$data = array();
		
		$code = $this->input->post('single');
	
		$device_id = $this->session->userdata('temp_device_id');
		$account_id = $this->session->userdata('temp_account_id');

		$user_offset = $this->input->post('user_offset');
		$ip = $this->input->ip_address();
		$timestamp = date('Y-m-d G:i:s');

		//$last_id = $this->db->insert_id();
		//var_dump($account_id);
		
		$this->db->select('*');
		$this->db->where('device_id', $device_id);
		$this->db->where('account_id', $account_id);
		
		$Q = $this->db->get('code');
	    if ($Q->num_rows() > 0){
	      $data = $Q->result_array();
	    }
		
	    $Q->free_result();    
	    return $data;   
	    
	}
	function get_device_name()
	{
		// Gets device name based on URI segment
		$id = $this->uri->segment(4);
		$query = $this->db->get_where('device', array('id' => $id));	
		return $query->row();

	}
	function code_all()
	{
		$device_id = $this->session->userdata('temp_device_id');
		$query = $this->db->get_where('code', array('device_id' => $device_id));	
		return $query->row();
	}

}

/* End of file check_m.php */
/* Location: ./application/models/check_m.php */