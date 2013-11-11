<?php 

class Reports extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_report', 'report');
		$this->load->helper('date');
		// $this->output->enable_profiler(TRUE);
		error_reporting(E_ALL);
		// Set default timezone
		date_default_timezone_set("Europe/London");
	}

	public function index()
	{
		$this->auth->action('summary', 'report');
		
		$devices = $this->account->ownDevice;
		
		// get the total number of codes entered for this period
		//$from = $this->report->get_from('Y-m-d');
		//$to = $this->report->get_to()->modify('+ 1 day')->format('Y-m-d');

		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$account_id = $this->account->id;
		
		// if the user has clients, show how many codes *they've* entered
		if ($this->account->has_clients()) {
			$total_entered = R::getCol('SELECT COUNT(code) FROM code WHERE inputter_account_id = ? AND `added_at` BETWEEN ? AND ?', array($account_id, $from, $to));
			$total_seconds = R::getCol('SELECT SUM(duration) FROM code WHERE type = ? AND inputter_account_id = ? AND `added_at` BETWEEN ? AND ?', array('pair', $account_id, $from, $to));
		
		} else {
		// else show how many codes have been entered where they own the device
			$total_entered = R::getCol('SELECT COUNT(code) FROM code WHERE account_id = ? AND `added_at` BETWEEN ? AND ?', array($account_id, $from, $to));
			$total_seconds = R::getCol('SELECT SUM(duration) FROM code WHERE type = ? AND account_id = ? AND `added_at` BETWEEN ? AND ?', array('pair', $account_id, $from, $to));

			$codes = R::find('code', 'account_id = ? AND `time` BETWEEN ? AND ? ORDER BY `time`', array($account_id, $from, $to));
			$codes = array_values($codes);
		}
		
		$total_entered = $total_entered[0];
		$total_seconds = $total_seconds[0];

		$this->load->model('report');
		$saved_reports = $this->report->get_reports();

		if (!$total_seconds) {
			$total_seconds = 0;
			$total_duration = '0 minutes';
		} else {
			$total_duration = timespan(0, $total_seconds);
		}
		$title = 'Reports';
		$device_groups = $this->device_m->get_device_groups();

		// Device group pagination
/*

		$this->load->library('pagination');
		$this->load->model('device_m');

		$data['base']=$this->config->item('base_url');

		$total = $this->device_m->count_device_groups();
		$per_pg = 3;
		$offset = $this->uri->segment(3);

		$config['base_url'] = $data['base'].'/clients/reports/';
		$config['total_rows'] = $total;
		$config['per_page'] = $per_pg;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
	    $config['last_link'] = false;
	    $config['first_tag_open'] = '<li>';
	    $config['first_tag_close'] = '</li>';
	    $config['prev_link'] = '&laquo;';
	    $config['prev_tag_open'] = '<li class="prev">';
	    $config['prev_tag_close'] = '</li>';
	    $config['next_link'] = '&raquo;';
	    $config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] =  '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page">';
		$config['num_tag_close'] = '</li>';
		$config['show_count'] = false;
		//$config['div'] = '#content';
		$this->jquery_pagination->initialize($config); //$this->pagination->initialize($config);

		$links = $this->jquery_pagination->create_links(); //$this->pagination->create_links();
        $query = $this->device_m->get_all_device_groups($per_pg,$offset);
		
*/
		$this->load->view('reports/summary', compact('total_entered','total_duration','saved_reports','title','device_groups','links','query'));
	}
	function list_all()
	{				
		$from = $this->report->get_from('Y-m-d');
		$to = $this->report->get_to()->modify('+ 1 day')->format('Y-m-d');
		
		$account_id = $this->account->id;
		
		$codes = R::find('code', 'account_id = ? AND `time` BETWEEN ? AND ? ORDER BY `time`', array($account_id, $from, $to));
		$codes = array_values($codes);		
		$title = 'Time Listings';
		$this->load->view('reports/times', compact('codes','title'));
	}



}
/* end of file reports.php */