<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sessions extends Base_Controller {

	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}

	public function index()
    {
    
        if ($this->input->post('btn_login'))
        {
            if ($this->authenticate($this->input->post('username'), $this->input->post('password')))
            {
                if ($this->session->userdata('status') == 1)
                {
                    redirect('cms/dashboard');
                }
                elseif ($this->session->userdata('status') == 0)
                {
                    redirect('guest');
                }
            }
        }

        $this->load->view('session_login');
        
    }

    public function logout()
    {
        //$this->session->sess_destroy();
        $l = $this->session->set_userdata('logout', 'You are now logged out');
        redirect('sessions/index');

        $this->session->unset_userdata('user_data');
    }

    public function authenticate($username, $password)
    {
        $this->load->model('user_model');

        if ($this->user_model->auth($username, $password))
        {
            return TRUE;
        }

        return FALSE;
    }
    // Edit my account 
    public function edit($id)
    {
        $user_id = $this->session->userdata('user_id');

        $this->layout->set('user_id', $user_id);
        $this->layout->set('title', 'Edit My Account');
        $this->layout->buffer('maincontent', 'sessions/edit_account');
        $this->layout->render();    

    }


}