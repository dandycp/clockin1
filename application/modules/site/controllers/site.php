<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* Front-end controller
* Controls all frontend functions
* @params: $this->front->set(), 
* $this->front->buffer(), 
* $this->front->render()
*/


class Site extends Base_Controller {

	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('date');
		$this->load->library('pagination');
		$this->load->library('table');
		$this->load->library('user_agent');
	}
	// Index, main page that sorts pages from the cms dynamically  $path = ''
	public function index()
	{
		/*
	   	$page = $this->wc_main->getPagePath($path);
				
		$this->frontend->set('page', $page);	
		$this->frontend->set('title', ucfirst($page['title']));
		$this->frontend->set('metadesc', $page['meta_desc']);
		$this->frontend->set('metakeywords', $page['meta_keywords']);
		*/
		$this->frontend->set('title','Welcome');
		$this->frontend->buffer('content', 'site/index');
		$this->frontend->render();		
	}
	public function howitworks()
	{
		$title = 'How it works';
		$meta_desc = 'Installed ClockinPoint units automatically generate a unique encrypted 8 digit code which changes every 60 seconds to support accurate and indisputable timekeeping.';
		$meta_keys = 'clocking machines, clock in machinces, time management, time keeper';
		$this->load->view('header',compact('title','meta_desc','meta_keys'));
		$this->load->view('howitworks');
		$this->load->view('footer');
	}
	public function applications()
	{
		$title = 'Applications';
		$meta_desc = 'Local Authorities use ClockinPoint to prevent invoicing fraud from bill by hour suppliers, eliminate overpayments, manage asset servicing schedules';
		$meta_keys = '';
		$this->load->view('header',compact('title','meta_desc','meta_keys'));
		$this->load->view('applications');
		$this->load->view('footer');
	}
	public function benefits()
	{
		$title = 'Benefits';
		$meta_desc = 'exceptionally low cost - ROI within 1-3 months for every client
no internet connectivity required
no power connection required
quick and easy to install and set up';
		$meta_keys = '';
		$this->load->view('header',compact('title','meta_desc','meta_keys'));
		$this->load->view('benefits');
		$this->load->view('footer');
	}
	public function wheretobuy()
	{
		$title = 'Where to buy';
		$meta_desc = 'ClockinPoint has a national network of distributors and resellers';
		$meta_keys = '';
		$this->load->view('header',compact('title','meta_desc','meta_keys'));
		$this->load->view('wheretobuy');
		$this->load->view('footer');
	}
	public function contact() 
	{
		$title = 'Contact ClockinPoint';
		$meta_desc = 'ClockinPoint, Unit 17 Apple Lane Exeter, EX2 5GL - T: 01392 357 230';
		$meta_keys = '';
		$this->load->view('header',compact('title','meta_desc','meta_keys'));
		$this->load->view('contact');
		$this->load->view('footer');
	}

    public function authenticate($email, $password)
    {
        $this->load->model('site_model');

        if ($this->site_model->auth($email, $password))
        {
            return TRUE;
        }

        return FALSE;
    }
	public function partners()
	{
		$this->load->library('form_validation');

		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$this->form_validation->set_rules('email','Email Address','valid_email|required');
		$this->form_validation->set_rules('password','Password','required');

		if ($this->form_validation->run() == FALSE){
			$error = validation_errors();
			$this->frontend->set('errors', $error);
			$this->frontend->set('title','Partners - Please Login');
			$this->frontend->buffer('content','site/partners_login');
			$this->frontend->render();
		}
		if ($this->input->post('btn_login'))
        {
            if ($this->authenticate($this->input->post('email'), $this->input->post('password')))
            {
            	redirect('partners_area');
            }
            else {
            	$this->session->set_userdata('message','Sorry those details are incorrect, please try again');
            	redirect('partners');
            }
        }
	}
	public function partners_area()
	{
		$this->frontend->set('title','Partners Area');
		$this->frontend->buffer('content','site/partners_area');
		$this->frontend->render();
	}
	public function logout()
	{
		$this->session->sess_destroy();
        redirect('partners');
	}


}