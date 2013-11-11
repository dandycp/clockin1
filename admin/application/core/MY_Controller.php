<?php 

class MY_Controller extends CI_Controller {

	public $user;
	
    function __construct()
    {
        parent::__construct();
		// load the currentuser object as a simple variable for the convenience of our views
		$user_id = $this->session->userdata('user_id');
		$this->user = ($user_id) ? R::load('user', $user_id) : false ;
		$this->account = ($user_id) ? $this->user->account : false ;
		ini_set('memory_limit', '-1');
				
		// check that only one instance of a user can be logged in at the same time
		$session_id = $this->session->userdata('session_id');
		if (isset($this->user->session_id) && $this->user->session_id != $session_id) {
			$this->session->sess_destroy();
			$this->session->set_flashdata('message', 'This account has been logged into from another device. You have been logged out.');
			redirect('/clients/login');
		}
		
    }
	
	// just a simple way to show a chromed message to the user
	protected function show_message($heading, $message)
	{
		$this->load->view('common/message', compact('heading', 'message'));
	}



}