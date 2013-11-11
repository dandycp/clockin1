<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms extends Base_Controller {

	public function __construct()
	{
		parent::__construct();

		// Load model
		$this->load->model('pages_model');
		$this->load->model('cms_model');
		$pages = $this->pages_model->getAll();
		$this->layout->set('page', $pages);


		// Checks if the admin user is logged in, if they are not then it will redirect to login screen
		if ($this->session->userdata('is_logged_in') != true) { redirect('sessions/logout'); }
	}
	// Main Dashboard
	public function dashboard()
	{
		$this->load->library('pagination');

		$count = $this->cms_model->account_count();

		$config['base_url'] = site_url();
		$config['total_rows'] = $count;
		$config['per_page'] = 8; 
		$config['uri_segment'] = 3;

		$this->pagination->initialize($config); 

		$this->cms_model->paginate()->result();

		$this->layout->set('pagination', $this->pagination->create_links());
		$this->layout->set('registrations', $this->cms_model->getAllAccounts());
		$this->layout->set('title', 'Dashboard');
		$this->layout->buffer('maincontent', 'cms/dashboard');
		$this->layout->render();	
	}

	// Pages - Show list
	public function pages()
	{
		// Shows list of all pages
		$pages = $this->pages_model->getAll();

		$this->layout->set('title', 'Pages');
		$this->layout->set('page', $pages);
		$this->layout->buffer('maincontent', 'cms/pages');
		$this->layout->render();
	}

	// Create New Page
	public function create_page()
	{
		// Set validation rules
		$this->form_validation->set_rules('title','Title','required|max_length[100]');
		$this->form_validation->set_rules('description','Decription','max_length[100]');
		$this->form_validation->set_rules('content','Content','required|trim');
		$this->form_validation->set_rules('slug','Slug','required|trim');
		$this->form_validation->set_rules('status','Status','required');

		if ($this->form_validation->run() == FALSE) {
			$errors = validation_errors();
			$this->layout->set('error', $errors);
			$this->layout->set('title', 'Create New Page');
			$this->layout->buffer('maincontent','cms/create_page');
			$this->layout->render();
		}
		else {
			$this->pages_model->create_new_page();
		}

	}

	// Edit Page
	public function edit_page($id = '')
	{
		$id = $this->uri->segment(3);
		// Set validation rules
		$this->form_validation->set_rules('title','Title','required|max_length[100]');
		$this->form_validation->set_rules('description','Decription','max_length[100]');
		$this->form_validation->set_rules('content','Content','required|trim');
		$this->form_validation->set_rules('slug','Slug','required|trim');
		$this->form_validation->set_rules('status','Status','required');

		if ($this->form_validation->run() == FALSE) {
			$errors = validation_errors();
			$this->layout->set('error', $errors);
			$this->layout->set('page', $this->pages_model->getAllbyID($id));
			$this->layout->set('title', 'Edit Page');
			$this->layout->buffer('maincontent','cms/edit_page');
			$this->layout->render();
		}
		else {
			$this->pages_model->edit_page($id);
		}
		
	}

	// Remove page
	public function delete_page($id)
	{
		$this->pages_model->delete_page($id);
	}

	// Financial info
	public function financials()
	{
		// To show all financial details of all accounts
	}

}

