<?php 

class Reports extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_report', 'report');
		$this->load->helper('date');
		// $this->output->enable_profiler(TRUE);
		// error_reporting(E_ALL);
	}

	// our summary/welcome screen
	public function index()
	{
		$this->auth->action('summary', 'report');
		
		$devices = $this->account->ownDevice;
		
		// get the total number of codes entered for this period
		$from = $this->report->get_from('Y-m-d');
		$to = $this->report->get_to()->modify('+ 1 day')->format('Y-m-d');
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
		

		if (!$total_seconds) {
			$total_seconds = 0;
			$total_duration = '0 minutes';
		} else {
			$total_duration = timespan(0, $total_seconds);
		}
		$title = 'Reports';
		$this->load->view('reports/summary', compact('total_entered','total_duration','title'));
	}
	
	// list of individual times
	function times()
	{		
		$this->auth->action('times', 'report');
		
		$from = $this->report->get_from('Y-m-d');
		$to = $this->report->get_to()->modify('+ 1 day')->format('Y-m-d');
		
		$account_id = $this->account->id;
		
		$codes = R::find('code', 'account_id = ? AND `time` BETWEEN ? AND ? ORDER BY `time`', array($account_id, $from, $to));
		$codes = array_values($codes);		
		$title = 'Times';
		$this->load->view('reports/times', compact('codes','title'));
	}
	
	
	// list of durations
	function durations()
	{
		$this->auth->action('durations', 'report');
		
		$from = $this->report->get_from('Y-m-d');
		$to = $this->report->get_to()->modify('+ 1 day')->format('Y-m-d');
		
		$account_id = $this->account->id;
		
		$codes = R::find('code', "account_id = ? AND type = ? AND `time` BETWEEN ? AND ? ORDER BY `time`", 
			array($account_id, 'pair', $from, $to));
		
		$codes = array_values($codes);
		
		// calculate our total time
		$duration = 0;
		if (!empty($codes)) foreach ($codes as $code) {
			$duration+= $code->duration;
		}
		$total_time = timespan(0, $duration);
		$title = 'Durations';
		$this->load->view('reports/durations', compact('codes','total_time','title'));
	}
	
	// list of individual times
	function client_times()
	{
		$this->auth->action('client_times', 'report');
		
		$from = $this->report->get_from('Y-m-d');
		$to = $this->report->get_to()->modify('+ 1 day')->format('Y-m-d');
		
		$account_id = $this->account->id;
		
		$params = array($account_id, $from, $to);
		$codes = R::find('code', 'inputter_account_id = ? AND `time` BETWEEN ? AND ? ORDER BY `time`', $params);
		$codes = array_values($codes);
		
		$this->load->view('reports/client_times', compact('codes'));
	}
	
	
	// list of durations
	function client_durations()
	{
		$this->auth->action('client_durations', 'report');

		$from = $this->report->get_from('Y-m-d');
		$to = $this->report->get_to()->modify('+ 1 day')->format('Y-m-d');
		
		$account_id = $this->account->id;
		$params = array($account_id, 'pair', $from, $to);
		$codes = R::find('code', 'inputter_account_id = ? AND type = ? AND `time` BETWEEN ? AND ? ORDER BY `time`', $params);
		$codes = array_values($codes);
		
		// calculate our total time
		$duration = 0;
		if (!empty($codes)) foreach ($codes as $code) {
			$duration+= $code->duration;
		}
		$total_time = timespan(0, $duration);
		
		$this->load->view('reports/client_durations', compact('codes','total_time'));
	}
	
	
	/* REMOVED
	function download()
	{
		// expects to receive parameters: type (single|double), from, to, device_id
		$type = $this->input->get_post('type') or die('type is a required field');
		$from = $this->input->get_post('from') or die('from is a required field');
		$to = $this->input->get_post('to') or die('to is a required field');
		$device_id = (int) $this->input->get_post('device_id') or die('device_id is a required field');
		
		$device = R::load('device', $device_id) or die('device not found');
		
		$type_condition = ($type=='single') ? "c.`type`='single'" : "c.`type` IN ('start','end')";
		$query_string = "
			SELECT c.`code`, c.`time`, c.added_at, c.device_id, IF(u.company_name<>'', u.company_name, CONCAT(u.first_name,' ',u.last_name)) AS added_by 
			FROM code AS c 
			LEFT JOIN `user` AS u ON c.user_id = u.id
			WHERE device_id = $device_id AND DATE(`time`) BETWEEN '$from' AND '$to' AND $type_condition 
			ORDER BY `time`
			";
		
		$this->load->dbutil();
		$query = $this->db->query($query_string);
		$delimiter = ",";
		$newline = "\r\n";
		$csv = $this->dbutil->csv_from_result($query, $delimiter, $newline); 
		header('Content-Type: application/csv');
		header("Content-Disposition: attachment; filename=clockinpoint_" . time() . ".csv");
		header('Pragma: no-cache');
		echo $csv;
		exit;
		
	}*/
	
	// used to set the current reporting period
	function set_period()
	{
		$referer 			= $_SERVER['HTTP_REFERER'];
		$from 				= $this->input->post('from');
		$to 				= $this->input->post('to');
		
		$this->report->set_period($from, $to);
		
		redirect($referer);
		
	}
	/*
	function store_report()
	{
		// TO DO ability to store the report generated.
		// $html = $_REQUEST['html'];
		// $html = $this->load->view('reports/store', compact('html'), true);

		$html = $_REQUEST['html'];
		
		$this->load->helper('date');
		$root = dirname(__FILE__).'/../../';
		$html = $this->load->view('reports/store', compact('html','root'), true);
		$filename = 'Report';
		//die($html);
		
		$this->load->library('dompdf_lib');
		$this->dompdf_lib->create($html, $filename, TRUE, 'landscape');
	}
	*/
	function stored_reports()
	{
		//$this->auth->action('stored_reports', 'report');
		
		$saved_reports = $this->report->get_reports();		
		$this->load->view('reports/saved_reports', compact('saved_reports'));
	}
	function remove_reports($id)
	{
		$this->report->remove_report($id);
		$this->session->set_flashdata('message', 'Report has been removed.');
		redirect('/reports/stored_reports');
	}






}