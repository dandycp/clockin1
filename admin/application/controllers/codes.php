<?php 

require_once APPPATH . '/libraries/payload.php';

class Codes extends MY_Controller
{
	private $recent_code_ids = null;

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		//$this->output->enable_profiler(TRUE);
		// Set default timezone
		date_default_timezone_set("Europe/London");

	}
	
	function index()
	{
		$this->auth->action('add', 'code');
		$error = false;
		$this->session->unset_userdata('recent_code_ids');
		$clients = $this->account->get_clients(true);
		$people = $this->account->get_people();
		$categories = $this->account->get_categories();
		$providers = $this->account->get_providers(true);
		$show_custom_1 = (!empty($this->account->custom_1_name));
		$show_custom_2 = (!empty($this->account->custom_2_name));
	
		if (empty($clients) && !$this->account->has_devices()) $error = 'You do not currently have any clients or devices set up that you can enter codes for';
		
		if ($data = $this->input->post()) {
			
			try {
				
				// validation & prep
				$codes = array();
				$batch_ref = $this->generate_batch_reference();

				if (isset($data['client_id']) && empty($data['client_id'])) throw new Exception('A client must be selected');				
				$account_id = (!empty($data['client_id'])) ? (int) $data['client_id'] : $this->account->id;
				$account = R::load('account', $account_id);
				
				if (!$account) show_404();
				
				if (!empty($data['singles'])) foreach ($data['singles'] as $i => $line) {
					$code = trim(strtoupper($line['code']));
					$person_id = (!empty($line['person_id'])) ? $line['person_id'] : NULL ;
					$category_id = (!empty($line['category_id'])) ? $line['category_id'] : NULL ;
					$provider_id = (!empty($line['provider_id'])) ? $line['provider_id'] : NULL ;
					$custom_1 = (!empty($line['custom_1'])) ? $line['custom_1'] : NULL ;
					$custom_2 = (!empty($line['custom_2'])) ? $line['custom_2'] : NULL ;
					
					$result = $this->validate($code, $account_id);
					if (!$result['valid']) continue;
					$codes[] = array(
						'code'=>$code, 'type'=>'single', 
						'batch_ref'=>$batch_ref, 'person_id'=>$person_id,
						'category_id'=>$category_id, 'provider_id'=>$provider_id, 
						'custom_1'=>$custom_1, 'custom_2'=>$custom_2
					);
				}
				
				if (!empty($data['pairs'])) foreach ($data['pairs'] as $i => $line) {
					
					if (empty($line['start']) || empty($line['end'])) continue;
					$code = trim(strtoupper($line['start']));
					$end_code = trim(strtoupper($line['end']));
					$person_id = (!empty($line['person_id'])) ? $line['person_id'] : NULL ;
					$category_id = (!empty($line['category_id'])) ? $line['category_id'] : NULL ;
					$provider_id = (!empty($line['provider_id'])) ? $line['provider_id'] : NULL ;
					$custom_1 = (!empty($line['custom_1'])) ? $line['custom_1'] : NULL ;
					$custom_2 = (!empty($line['custom_2'])) ? $line['custom_2'] : NULL ;
					$result = $this->validate($code, $account_id);
					if (!$result['valid']) continue;
					$result = $this->validate($end_code, $account_id);
					
					// todo - need to check end is after start
					
					if (!$result['valid']) continue;
					$codes[] = array(
						'code'=>$code, 'end_code'=>$end_code, 'type'=>'pair', 
						'batch_ref'=>$batch_ref, 'person_id'=>$person_id,
						'category_id'=>$category_id, 'provider_id'=>$provider_id, 
						'custom_1'=>$custom_1, 'custom_2'=>$custom_2
					);
				}
				
				if (empty($codes)) throw new Exception('No valid codes were entered');
				
				// if no errors so far, we have passed validation
				// now save them
				foreach ($codes as $code) $this->save_code($code, $account);
				
			} catch (Exception $e) {
				$error = $e->getMessage();	
			}
			
			if (!$error) redirect('clients/codes/summary');
		}
		$title = 'Enter Codes';
		$this->load->view('codes/enter', compact('error','clients','providers','people','categories','show_custom_1','show_custom_2','codes','title'));
	}
	
	// this is an admin-only function used for generating valid timecodes
	function generate()
	{		
		// some meagre security
		if (!isset($_GET['pw']) || $_GET['pw'] != 'cp') die('Denied');
		if (!$this->user) show_404();
		$devices = $this->account->ownDevice;
		$device_id = null;
		$secret_key = null;
		$initial_timecode = null;
		$initial_timestamp = null;
		$error = false;
		$timestamp = time();
		$time = date("Y-m-d H:i", $timestamp);
		$code = false;
		$minutes_elapsed = 0;
		
		if (!empty($_POST['time'])) {
			// 	generate code			
			$this->load->library('encryption');
			
			$secret_key = $this->account->secret_key;
			$device_id = $_POST['device_id'];
			$device = R::load('device', $device_id);
			$time = $_POST['time'];
			$timestamp = strtotime($time);
			$initial_timestamp = strtotime($device->initial_time);
			$initial_timecode = $device->initial_code;
			$seconds_elapsed = $timestamp - $initial_timestamp;
			
			// validation
			if ($timestamp < $initial_timestamp) $error = 'Oops, that\'s an invalid code';
			
			// expriemental:
			$t0 = $initial_timecode;
			$minutes_elapsed = ceil($seconds_elapsed / 60);
			
			$low_battery = false;
			$error_code = 0;
			$this->encryption->packCipherText($text, $secret_key, $device_id, $t0, $minutes_elapsed, $low_battery, $error_code);
			
			$code = $text;
			
			
		}
		$title = 'Generate New Codes';
		$this->load->view('codes/generate', compact(
			'devices','device_id','secret_key','initial_timecode', 'initial_timestamp', 'error','time','timestamp','code','minutes_elapsed','title'
		));
	}
	
	// a stand-alone page that lets users find an appropriate replacement for a code that has been incorrectly recorded
	function finder()
	{
		if (!$this->user) $this->auth->access_restricted();
		$devices = $this->account->ownDevice;
		$device_id = null;
		$error = false;
		$date = null;
		$time = null;
		$code = null;
		$range = 15;
		
		// see if form has been posted
		if ($data = $this->input->post()) {
			
			$secret_key = $this->account->secret_key;
			$device_id = $data['device_id'];
			$device = R::load('device', $device_id);
			$date = $data['date'];
			$time = $data['time'];
			$timestamp = strtotime($date . ' ' . $time);
			$initial_timestamp = strtotime($device->initial_time);
			$initial_timecode = $device->initial_code;
			$min_matching_characters = 0;
			
			$this->load->library('encryption');
			$format = 'Y-m-d H:i:s P';
			
			// translate variable names into AS's
			$text = $code		= $data["code"];
			$key                = $secret_key;
			$expected_serial    = $device_id;
			$t0                 = $initial_timecode;
			$d0                 = $initial_timestamp;
			$expected_timestamp = $timestamp;
			//$range              = $data["range"];
			
			if(isset($_POST["lowB"]))
				$low_battery = true;
			else
				$low_battery = false;
			
			$datetime = new DateTime();
			$datetime->setTimestamp($expected_timestamp);
				
			$enc = new Encryption();
			$results = array();
			if($enc->checkBadCipherText($text, $expected_serial, $expected_timestamp, $key, $t0, $d0, $low_battery, $range, $report, $error_code)) {
				foreach($report as $line) {
					if ($line['correct'] > $min_matching_characters) {
						// construct our results array
						$datetime->setTimestamp($line["timestamp"]);
						$result = array(
							'matches' => $line['correct'], 'code' => $line['expected_text'], 'time'=> $datetime->format('H:i')
						);
						$results[] = $result;
					}
				}
				// sort the results so they're ordered by which has the most matching characters
				uasort($results, function($a, $b) { return $b['matches'] - $a['matches']; });
				
			} else {
				$error = 'Error: ' . $error_code;
			}
		}
		
		$this->load->view('codes/finder', compact('error','code','date','time','device_id','devices','results','range','data'));
	}
	
	// code_arr should be an array containing :code, (:end_code), :type, :batch_ref
	private function save_code($code_arr, $account) 
	{
		
		$type = $code_arr['type'];
		$batch_ref = $code_arr['batch_ref'];
		
		$code_string = $code_arr['code'];
		$end_code_string = ($type == 'pair') ? $code_arr['end_code'] : NULL ;
		
		$time = $this->code_to_time($code_string, $account);		
		$end_time = ($end_code_string) ? $this->code_to_time($end_code_string, $account) : NULL ;
		
		// swap pairs around if they've entered start/end in wrong order
		if ($end_time && $time > $end_time) {
			
			$swap = $end_time;
			$end_time = $time;
			$time = $swap;
			
			$swap = $end_code_string;
			$end_code_string = $code_string;
			$code_string = $swap;
			
		}
		
		$format = 'Y-m-d H:i:s P';
		$time_string = $time->format($format);
		$end_time_string = ($end_time) ? $end_time->format($format) : NULL ;
		
		$device = $this->code_to_device($code_string, $account);
		
		$code = R::dispense('code');
		$code->code = $code_string;
		$code->end_code = $end_code_string;
		$code->type = $type;
		$code->inputter_id = $this->user->id;
		$code->inputter_account_id = $this->account->id;
		$code->device_id = $device->id;
		$code->account_id = $device->account_id;
		$code->time = $time_string;
		$code->end_time = $end_time_string;
		$code->batch_ref = $batch_ref;
		$code->person_id = isset($code_arr['person_id']) ? $code_arr['person_id'] : null ;
		$code->category_id = isset($code_arr['category_id']) ? $code_arr['category_id'] : null ;
		$code->provider_id = isset($code_arr['provider_id']) ? $code_arr['provider_id'] : null ;
		$code->inputter_ip  = $this->input->ip_address();
		$code->custom_1 = isset($code_arr['custom_1']) ? $code_arr['custom_1'] : null ;
		$code->custom_2 = isset($code_arr['custom_2']) ? $code_arr['custom_2'] : null ;
		
		
		$id = R::store($code);
		$ids = ($this->session->userdata('recent_code_ids')) ? $this->session->userdata('recent_code_ids') : array() ;
		$ids[] = $id;
		$this->session->set_userdata('recent_code_ids', $ids);
	}
	
	function code_to_time($code, $account=false)
	{
		// find out what time this code relates to
		$this->load->library('encryption');
		if (!$account) $account = $this->account;
		$key = $account->secret_key; 
		$code = trim(strtoupper($code));
		
		if ($this->encryption->unpackCipherText($code, $key, $payload, $error_code)) 
		{
			$device_id = $payload->getDeviceId();
			$device = R::load('device', $device_id);
			// todo - check they have permissions for this device
			$initial_timestamp = strtotime($device->initial_time);
			$date = $payload->getDateTime($device->initial_code, $initial_timestamp);
			$low_batt = $payload->getLowBattery();
			// check that the time is not before the device was set up
			$earliest_date = new DateTime($device->initial_time);			
			if ($date < $earliest_date) throw new Exception('<span class="txt-alert">Oops, that\'s an invalid code.</span>');
			
			return $date;
			
		} else {
			log_message('debug', 'Code could not be converted to time: ' . $error_code);
			throw new Exception('Code is not valid');
		}
		
	}
	
	function code_to_device($code, $account=false)
	{
		// find out what device this code relates to
		$this->load->library('encryption');
		if (!$account) $account = $this->account;
		$key = $account->secret_key; 
		$code = trim(strtoupper($code));
		if ($this->encryption->unpackCipherText($code, $key, $payload, $error_code)) 
		{
			$device_id = $payload->getDeviceId();
			$device = R::load('device', $device_id);
			return $device;
			
		} else {
			log_message('debug', 'Code could not be related to a device: ' . $error_code);
			throw new Exception('Invalid code - device not found');
		}
		
	}
	
	function summary()
	{	
		$this->load->helper('date');
		$ids = $this->session->userdata('recent_code_ids');
		if (!$ids) show_404();
		$singles = R::find('code', "type='single' AND id IN (". R::genSlots($ids) . ") ORDER BY `time`", $ids);
		$pairs = R::find('code', "type='pair' AND id IN (". R::genSlots($ids) . ") ORDER BY `time`", $ids);
		
		
		$singles = array_values($singles);
		$pairs = array_values($pairs);
		
		// calculate our total time
		$duration = 0;
		if ($pairs) foreach ($pairs as $code) {
			$duration+= $code->duration;
		}
		
		$total_time = timespan(0, $duration);
		
		// get our batch reference
		if ($singles) $batch_ref = $singles[0]->batch_ref;
		else $batch_ref = $pairs[0]->batch_ref;
		$title = 'Code Summary';
		$this->load->view('codes/summary', compact('singles', 'pairs', 'batch_ref', 'total_time','title'));
	}
	
	// validates a code passed as the 3rd segment of the url
	function validate($code='', $account_id=false)
	{
		$valid = true;
		$reason = '';
        $timestamp = null;
		$device = new StdClass();
		if (!$account_id) $account = $this->account;
		else $account = R::load('account', $account_id);
		
		try {
			
			if (!$account) throw new Exception('Account not found');
	
			if (strlen($code) != 8) throw new Exception('Code must be exactly 8 characters long');
			
			if (!preg_match('/[a-z0-O]{8}/i', $code)) throw new Exception('Code must only contain a-z, 0-9');
			
			$time = $this->code_to_time($code, $account);
			$our_device = $this->code_to_device($code, $account);
			
			// check whether the code has been used previously and whether that exceeds the settings on the device
			if ($previous = R::find('code','code=? AND account_id=?', array($code, $account->id))) {
				if ($previous && count($previous) > $our_device->max_code_reuse)
					throw new Exception('Code ' . $code . ' has been entered previously');
			}
			
			$device->id = $our_device->id;
			$device->name = '<strong>'.$our_device->name. '</strong>';
			$format = 'j M Y - H:i';
			$time_string = $time->format($format);
            $timestamp = $time->getTimestamp();
			$reason = $time_string;
			$valid = true;
		} catch (Exception $e) {
			$valid = false;
			$reason = $e->getMessage();
		}
			

		$result = array('valid'=>$valid, 'reason'=>$reason, 'device'=>$device, 'timestamp'=>$timestamp);
		if ($this->input->is_ajax_request()) {
			echo json_encode($result);
			exit;
		} else {
			return $result;
		}
		
	}
	
	// generate a unique reference to a batch of codes
	// typically this is used where the user doesn't wish to input an invoice number themselves after entering
	// a bunch of codes
	function generate_batch_reference()
	{
		$this->load->database();
		$result = $this->db->query("SELECT MAX(id)+1 AS 'num' FROM code")->row_array();
		$input = $result['num'];
		$output = 'U';
		
		// base 30! (commonly confused letters/number have been removed, including 'E' which can cause problems with scientific notation)
		$index = array('2','3','4','5','6','7','8','9','A','B','C','D','F','G','H','J','K','M','N','P','Q','R','S','T','U','V','W','X','Y','Z');
		
		$base = count($index);
	
		$converted = base_convert($input, 10, $base);
		
		$ref = '';
		// now loop through the new base 30 string and convert to using our preferred characters only
		for ($i=0; $i<strlen($converted); $i++) {
		 $char = substr($converted, $i, 1);
		 $pos = base_convert($char, $base, 10);
		 $newchar = $index[$pos];
		 $ref.= $newchar;
		}
		
		// now pad this to 5 chars min
		// should be safe (avoid collisions) padding with "1" as we're not using this in our index array
		$padded = str_pad($ref, '5', '1', STR_PAD_LEFT);
		
		$output.= $padded;
		
		// generate a 2 digit random num to add to the end to decrease chance of collision if bookings made in same milisecond
		// for instance if our database returned the same max orderID
		shuffle($index);
		$rand_num = $index[0] . $index[1];
		
		$output .= $rand_num;
		
		return $output;
	
	}
	
	
	// allows users to enter their own batch ref or invoice number to apply to a series of codes
	public function update_batch_ref()
	{
		$ids = $this->session->userdata('recent_code_ids');
		if (!$ids) show_404();
		$codes = R::find('code', "id IN (". R::genSlots( $ids) . ")", $ids);
		if (empty($codes)) show_404();
		$new_ref = $this->input->post('batch_ref');
		if (empty($new_ref)) die('Ref not found');
		
		// update old ref with new one
		foreach ($codes as $code) {
			$code->batch_ref = $new_ref;
			R::store($code);
		}
		redirect('codes/summary');
	}
	
	// Continue function - shows extra options like send to provider, user etc, option to print etc
	public function options()
	{
		$title = 'Options';
		$this->load->view('codes/continue', compact('title'));
	}

	
	

}