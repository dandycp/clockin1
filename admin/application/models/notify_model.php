<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notify_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_message()
	{
		$data = array();
		$this->db->select('id, user_id, account_number, message_content, created, status');
	 	//$this->db->where('account_number', $this->session->userdata('account_number'));
	 	$this->db->order_by('created', 'desc'); // Orders by date/time newest first
     	$Q = $this->db->get('messages');
     	if ($Q->num_rows() > 0){
       		foreach ($Q->result_array() as $row){
         	$data[] = $row;
        	}
    	}
    	$Q->free_result();  
    	return $data;
	}
	function read_message($id)
	{
		$data = array(
               'status' => '0',
               'txt' => 'read'

        );
		$this->db->where('id', $id);
		$this->db->update('messages', $data); 
		
	}
	function remove_after($id)
	{
		$this->load->helper('date');
		$time = date("Y-m-d H:i:s");
		$sql = "DELETE FROM `messages` WHERE `status` = '0' AND `created` < ($time - INTERVAL 2 MINUTE) AND `id` = $id";
		$this->db->query($sql);
	}

	function device_count()
    {
    	
    	$this->db->where('account_id', $this->session->userdata('account_number'));
    	return $this->db->count_all_results('device');
        //echo $this->db->count_all_results('device');
        //return $this;
    }
	

}

/* End of file  */
