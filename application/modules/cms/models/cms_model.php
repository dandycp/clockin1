<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms_model extends MY_Model {

	public $table = 'user';
	public $primary_key = 'id';
	public $date_created_field = 'date_created';

	// Get all active accounts
	function getAllAccounts()
	{
		$data = array();

		$this->db->select('*');
    	$Q = $this->db->get('user');

    	if ($Q->num_rows() > 0){
	      $data = $Q->result_array();
	    }
		
	    $Q->free_result();    
	    return $data;
	}
	// Count account for pagination
	function account_count()
	{
		$this->db->count_all('user');
	}

}

/* End of file cms_model.php */
/* Location: ./application/models/cms_model.php */