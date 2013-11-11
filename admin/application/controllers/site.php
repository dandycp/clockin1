<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		
		$data['title'] = 'Welcome';
		$this->load->view('front/head');
		$this->load->view('front/home');
		$this->load->view('front/foot');
	}

}

/* End of file  */
