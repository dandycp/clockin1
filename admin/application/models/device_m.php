<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Device_m extends MY_Model {

	
	public $_table = 'account';
	public $primary_key = 'id';
	/*
	* Returns device(s) based on logged in user
	*/
	public function getDevice()
	{
		$data = array();
		$this->db->select('*');
		$this->db->where('account_id', $this->session->userdata('account_id'));

		$q = $this->db->get('device');

		if ($q->num_rows() > 0) {
			foreach ($q->result_array() as $row) {
				$data = $row;
			}
		}
		$q->free_result();
		return $data;
	}

	function search($term)
	{
		$data = array();
		$this->db->select('*');
		$this->db->from('device');
		$this->db->join('address', 'address.id = device.address_id');
		$this->db->like('name', $term);
		//$this->db->or_like('location', $term);
		//$this->db->or_like('address_id', $term);
		//$this->db->or_like('postcode', $term);
	    //$this->db->order_by('id','asc');
	    $this->db->where('account_id', $this->session->userdata('account_id'));
	    // Join address details to address_id  $sql = "SELECT * FROM `clockin`.`address` WHERE `id` = 4 LIMIT 0, 30 ";
	    $Q = $this->db->get();
	    	if ($Q->num_rows() > 0){
	       		foreach ($Q->result_array() as $row){
	         		$data[] = $row;
       			}
			}
		$Q->free_result();    
		return $data;
	}
	function save_device_group()
	{
		$acc = $this->account['account_number'];
		$data = array(
			'group_name' => $this->input->post('userinput'), //Gets users input on search term
			'user_id'	 => $acc, // Gets user's account number
			'device' 	 => 1, // Set to 1 so we know it's a stored device group and nothing else
			'devices'    => serialize($this->session->userdata('search_result')), //Serialise array then dump into database
			'created' 	 => date("Y-m-d")
		);
		$this->db->insert('groups', $data);
	}
	function get_device_groups()
	{
		$acc = $this->account['account_number'];
		$data = array();
		$this->db->select('*');
		$this->db->where('user_id', $acc);

		$Q = $this->db->get('groups');

		if ($Q->num_rows() > 0){
       		foreach ($Q->result_array() as $row){
         	$data[] = $row;
        	}
    	}
		$Q->free_result();
		return $data;	
	}
	function count_device_groups()
	{
		return $this->db->count_all('groups');
	}
	function get_all_device_groups($per_pg,$offset)
    {
    	$query = $this->db->get('groups',$per_pg,$offset);
        return $query->result_array();
    }
	function delete_group($id)
	{
		 $this->db->delete('groups', array('id' => $id));
	}
	function get_device_codes()
	{
		$data = array();
		$uri = $this->uri->segment(4);
		//var_dump($uri);
		$this->db->select('*');
		$this->db->where('device_id', $uri);

		$q = $this->db->get('code');

		if ($q->num_rows() > 0) {
			foreach ($q->result_array() as $row) {
				$data[] = $row;
			}
		}
		$q->free_result();
		return $data;
	}



}

/* End of file device_m.php */
/* Location: ./application/models/device_m.php */