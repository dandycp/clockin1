<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice_model extends CI_Model {

	// Get active subscriptions
	function get_subscriptions()
	{
		$data = array();

		$this->db->select('*');
		$this->db->where('account_id', $this->session->userdata('account_id'));

		$q = $this->db->get('subscription');

		if ($q->num_rows() > 0) {
			foreach ($q->result_array() as $row) {
				$data[] = $row;
			}
		}
		$q->free_result();
		return $data;
	}
	// For list
	function get_invoices()
	{
		$data = array();

		$this->db->select('*');
		$this->db->where('account_id', $this->session->userdata('account_id'));

		$q = $this->db->get('invoice');

		if ($q->num_rows() > 0) {
			foreach ($q->result_array() as $row) {
				$data[] = $row;
			}
		}
		$q->free_result();
		return $data;
	}
	// For online view
	function get_invoices_view()
	{
		$data = array();

		$this->db->select('*');
		$this->db->where('account_id', $this->session->userdata('account_id'));

		$q = $this->db->get('invoice');

		if ($q->num_rows() > 0) {
			foreach ($q->result_array() as $row) {
				$data = $row;
			}
		}
		$q->free_result();
		return $data;
	}
	function get_invoices_unpaid()
	{
		$data = array();

		$this->db->select('*');
		$this->db->where('account_id', $this->session->userdata('account_id'));
		$this->db->where('invoice_status','unpaid');

		$q = $this->db->get('invoice');

		if ($q->num_rows() > 0) {
			foreach ($q->result_array() as $row) {
				$data = $row;
			}
		}
		$q->free_result();
		return $data;
	}

}

/* End of file invoice_model.php */
/* Location: ./application/models/invoice_model.php */