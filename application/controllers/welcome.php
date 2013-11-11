<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->library('form_validation');

		$title = 'Welcome';
		$meta_desc = 'ClockinPoint is an innovative, low cost attendance validation system which can be used to monitor contractual time, ensure accuracy of account payments';
		$meta_keys = 'clocking in, time attendance, employee time attendance machine, clock in machine, clocking machines';

		// Set validation values
		$this->form_validation->set_rules('name','Contact Name','trim|required|min_length[2]');
		$this->form_validation->set_rules('company','Company','trim|required');
		$this->form_validation->set_rules('email','Email Address','trim|required|valid_email');
		$this->form_validation->set_rules('tel','Contact Number','trim|required|numeric|exact_length[11]');
		
		// Check validation is not set to false
		if ($this->form_validation->run() != TRUE) {
			$this->load->view('header', compact('title','meta_desc','meta_keys'));
			$this->load->view('home');
			$this->load->view('footer');
		}
		else {
			// If validation passes, send automated email to the user and to sales manager @ clockinpoint
			$name  = $this->input->post('name');
			$email = $this->input->post('email');
			$company = $this->input->post('company');
			$tel = $this->input->post('tel');

			$config['mailtype'] = 'html';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;

			$this->email->initialize($config);

			$logo  = base_url().'img/logo.gif';
			
			$message = "<img src='$logo' /><br /><br />
						Hello Admin,<br />
						A new customer has sent a request for more info from the ClockinPoint website. Their details are as follows:-<br /><br />
						<strong>Name:</strong> $name<br />
						<strong>Email Address:</strong> $email<br />
						<strong>Company:</strong> $company<br />
						<strong>Telephone:</strong> $tel<br /><br />
						<strong>Generated from clockinpoint.com</strong>
						";
				
			
			$this->email->from($email, $name);
			$this->email->to('lstables1@gmail.com');
			$this->email->subject('ClockinPoint - More info request');
					
			$this->email->message($message);
			
			$this->email->send(); // Send the message function to the persons email address
			$this->email->clear(); // Clears the form ready for another submission

			// Send customer email
			$name  = $this->input->post('name');
			$email = $this->input->post('email');
			$company = $this->input->post('company');
			$tel = $this->input->post('tel');

			$config['mailtype'] = 'html';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;

			$this->email->initialize($config);

			$logo  = base_url().'img/logo.gif';
			
			$message = "<img src='$logo' /><br /><br />
						Hi, '$name'<br />
						Thank you for your request for more information about ClockinPoint.<br />
						";
				
			
			$this->email->from($email, $name);
			$this->email->to('lstables1@gmail.com');
			$this->email->subject('ClockinPoint - More info request');
					
			$this->email->message($message);
			
			$this->email->send(); // Send the message function to the persons email address
			$this->email->clear(); // Clears the form ready for another submission


		}
		
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */