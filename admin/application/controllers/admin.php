<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* Admin/CMS Controller
*/
class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// Load libraries & models
		//$this->load->library('Admin');
		
		
		//var_dump();
	}
	// Index, Admin Login Page
	public function index()
	{
		$this->load->view('admin/index');
	}
	// Check Login
	public function login()
	{

	}
	// Auth Login
	public function authenticate()
	{

	}


}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */