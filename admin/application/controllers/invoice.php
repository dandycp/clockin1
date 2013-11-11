<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Invoicing Controller for all account invoicing
*/

class Invoice extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('invoice_model');
		
	}

	public function index()
	{
		$title = 'Invoices &amp; Subscriptions';
		$account = $this->session->userdata('account_id');
		$subscriptions = $this->invoice_model->get_subscriptions();
		$invoices = $this->invoice_model->get_invoices();
		$inv = $this->invoice_model->get_invoices_view();

		$this->load->view('invoice/dashboard', compact('account','subscriptions','title','invoices','inv'));
	}
	public function view_invoice()
	{
		$invoice = $this->invoice_model->get_invoices_view();
		$title = 'Invoice '.$invoice['invoice_id'].'';

		$this->load->view('invoice/view_invoice', compact('title','invoice'));
	}

}

/* End of file invoice.php */
/* Location: ./application/controllers/invoice.php */