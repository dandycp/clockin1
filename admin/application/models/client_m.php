<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Client Model
* to grab selective stuff from db
*/
class Client_m extends MY_Model {

	public $_table = 'account';
	public $primary_key = 'id';


	// Get account details by session user id
	public function getAccount()
	{
		$data = array();
		$this->db->select('*');
		$this->db->where('id', $this->session->userdata('account_id'));
		$q = $this->db->get('account');

		if ($q->num_rows() > 0) {
			foreach ($q->result_array() as $row) {
				$data = $row;
			}
		}
		
		$q->free_result();
		return $data;
		
	}
	public function fetch_rate()
	{
		$data = array();
		$this->db->select('*');
		$this->db->where('id', $this->session->userdata('account_id'));
		$q = $this->db->get('account');

		if ($q->num_rows() > 0) {
			foreach ($q->result_array() as $row) {
				$data = $row;
			}
		}
		
		$q->free_result();
		return $data;	
	}
	public function account_number()
	{
		return random_string('numeric', 8);
	}
	// Save new created account  8 digit random code for account number
	public function saveAccount()
	{
		// This needs sorting, maybe re-use redBean and code before
		$data1 = array(
			'company_name'   => $this->input->post('company_name'),
			'business_type'  => $this->input->post('business_type'),
			'account_number' => $this->account_number(),
			'secret_key'     => strtoupper(random_string('alnum', 6)),
			'user_id'        => $this->db->insert_id()

		);
		$this->db->insert('account',$data1);

		$data = array(
			'title'		 => $this->input->post('title'),
			'first_name' => $this->input->post('first_name'),
			'last_name'	 => $this->input->post('last_name'),
			'email'		 => $this->input->post('email'),
			'password'   => sha1($this->input->post('password')),
			'tel'		 => $this->input->post('phone'),
			'job_title'  => $this->input->post('job_title'),
			'account_id' => $this->db->insert_id(),
			'usergroup_id'=> 1
		);
		$this->db->insert('user', $data);
		echo $this->db->last_query();
	}
	// NOT USED
	public function __reports()
	{
		$data = array();
		$this->db->select('*');
		$this->db->where('account_id', $this->session->userdata('account_id'));
		$q = $this->db->get('device');

		if ($q->num_rows() > 0) {
			foreach ($q->row_array() as $row)
				$data = $row;
		}

		$q->free_result();
		return $data;
	}
	function get_account_by_number()
	{
		$id = $this->uri->segment(4);
		$query = $this->db->get_where('account', array('account_number' => $id));	
		return $query->row();
	}
	function get_user_info()
	{	
		$c = $this->client_m->get_account_by_number();
		$client = $c->id;
		//var_dump($client);
		$id = $this->uri->segment(4);
		$query = $this->db->get_where('user', array('account_id' => $client));	
		return $query->row();	
	}
	function update_provider($id)
	{
		$hour_rate = $this->input->post('hour_rate');
		$tolerance = $this->input->post('tolerance_rate');
		$actual    = $this->input->post('acutal_hours');

		$data = array(
               'tolerance_rate' => $tolerance,
               'hour_rate' => $hour_rate,
               'actual_hours' => $actual
            );

		$this->db->where('account_number', $id);
		$this->db->update('account', $data); 
	}
	function get_account_for_notifications()
	{
		$uid = $this->client_m->get_account_by_number();
		$client = $uid->id;
		$data = array();
		$this->db->select('*');
		$this->db->where('account_number', $client);
		$q = $this->db->get('account');

		if ($q->num_rows() > 0) {
			foreach ($q->row_array() as $row)
				$data = $row;
		}

		$q->free_result();
		return $data;
	}
	function get_user_infofor_notifications()
	{	
		$c = $this->client_m->get_account_for_notifications();
		$client = $c->id;
		$id = $this->session->userdata('account_id');
		$query = $this->db->get_where('user', array('account_id' => $client));	
		return $query->row();	
	}
	function update_messages()
	{
		$id = $this->session->userdata('account_id');
		$info = $this->client_m->get_user_infofor_notifications();

		$data = array(
			'account_id'    => $id,
			'content'       => 'some content',
			'status'        => 1
		);

		$this->db->insert('message', $data);
	}
	


}

/* End of file client_m.php */
/* Location: ./application/models/client_m.php */