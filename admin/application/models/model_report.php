<?php 

class Model_Report extends CI_Model {
	
	private $from = false;
	private $to = false;
	
	function __construct()
	{
		parent::__construct();
		
		$this->from = $this->session->userdata('reporting_from');
		$this->to = $this->session->userdata('reporting_to');

		$this->date_from = $this->session->userdata('reporting_date_from');
		$this->date_to = $this->session->userdata('reporting_date_to');
		
		if (!$this->from || !$this->to) {
			$from = new DateTime("NOW - 30 days");
			$to = new DateTime("NOW");
			$this->set_period($from, $to);
		}
		
	}
	
	function get_from($format = false)
	{
		if (!$format) return clone $this->from;
		else return $this->from->format($format);
	}
	
	function get_to($format = false)
	{
		if (!$format) return clone $this->to;
		else return $this->to->format($format);
	}
	
	// used to set the current reporting period
	function set_period($from, $to)
	{
		// validation
		if (!$from || !$to) return false;
		
		// convert to DateTime object if not already
		if (!is_a($from, 'DateTime')) $from = new DateTime($from);
		if (!is_a($to, 'DateTime')) $to = new DateTime($to);
		
		// further validation
		if ($from > $to) return false;
		
		$this->session->set_userdata('reporting_from', $from);
		$this->session->set_userdata('reporting_to', $to);
		
		$this->from = $from;
		$this->to = $to;
		
		return true;
	}	
	function get_reports()
	{
		$user = $this->session->userdata('user_id');
         // id 	user_id 	account_number 	stored 	file 	created 	status 	other 
		$data = array();
		$this->db->select('id, user_id, account_number, stored, file, created, status, other');
	 	$this->db->where('account_number',$this->account->account_number);
	 	$this->db->where('user_id', $user);
	 	//$this->db->order_by('created', 'desc'); // Orders by date/time newest first
     	$Q = $this->db->get('saved_reports');
     	if ($Q->num_rows() > 0){
       		foreach ($Q->result_array() as $row){
         	$data[] = $row;
        	}
    	}
    	$Q->free_result();  
    	return $data;
	}
	function remove_report($id)
	{
		$this->db->delete('saved_reports', array('id' => $id)); 
	}
	
}