<?php

/**
 * @property Auth $auth
 *
 * @property CI_DB_active_record $db
 * @property CI_DB_forge $dbforge
 * @property CI_Benchmark $benchmark
 * @property CI_Calendar $calendar
 * @property CI_Cart $cart
 * @property CI_Config $config
 * @property CI_Controller $controller
 * @property CI_Email $email
 * @property CI_Encrypt $encrypt
 * @property CI_Exceptions $exceptions
 * @property CI_Form_validation $form_validation
 * @property CI_Ftp $ftp
 * @property CI_Hooks $hooks
 * @property CI_Image_lib $image_lib
 * @property CI_Input $input
 * @property CI_Lang $lang
 * @property CI_Loader $load
 * @property CI_Log $log
 * @property CI_Model $model
 * @property CI_Output $output
 * @property CI_Pagination $pagination
 * @property CI_Parser $parser
 * @property CI_Profiler $profiler
 * @property CI_Router $router
 * @property CI_Session $session
 * @property CI_Sha1 $sha1
 * @property CI_Table $table
 * @property CI_Trackback $trackback
 * @property CI_Typography $typography
 * @property CI_Unit_test $unit_test
 * @property CI_Upload $upload
 * @property CI_URI $uri
 * @property CI_User_agent $user_agent
 * @property CI_Validation $validation
 * @property CI_Xmlrpc $xmlrpc
 * @property CI_Xmlrpcs $xmlrpcs
 * @property CI_Zip $zip
 * @property CI_Javascript $javascript
 * @property CI_Jquery $jquery
 * @property CI_Utf8 $utf8
 * @property CI_Security $security
 */

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