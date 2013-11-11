<?php 

class Devices extends MY_Controller
{
	
	
	function index()
	{
		@session_start();
		$this->load->library('pagination');
		$this->load->model('notify_model');

		$this->auth->action('list', 'device');
		$devices = $this->account->ownDevice;
		

		$total = $this->notify_model->device_count();
		$per_pg = 5;
		
		$config['base_url'] = base_url().'devices/list/';
		$config['total_rows'] = $total;
		$config['per_page'] = 5;
        $config['uri_segment'] = 3;
		$config['full_tag_open'] = '<div class="pagination">';
	    $config['full_tag_close'] = '</div>';
	    $this->pagination->initialize($config);
        $pagination = $this->pagination->create_links();
		$title= 'Devices';
		$this->load->view('devices/list', compact('devices','pagination','title'));
	}

	function add()
	{
		//$this->auth->action('add', 'device');
		// check they can add another device if one already setup
		$num_devices = count($this->account->ownDevice);
		$device_limit = $this->account->device_limit;
		if ($device_limit <= $num_devices) {
			$this->session->set_flashdata('message',
				'You currently have a limit of ' . $device_limit . ' devices on your account. 
				Please view your <a href="account/edit">Account Settings</a> page for upgrade options.');
			redirect('devices');
		}

		$error = false;
		$device = R::dispense('device');
		$address = R::dispense('address');
		$countries = R::find('country', '1 ORDER BY name');
		
		if ($data = $this->input->post()) {
			
			try {
				$device->import($data, 'name,location');
				$address->import($data['address'], 'line_1,line_2,city,postcode,country_id');
				$device->address = $address;
				$device->account_id = $this->account->id;
				$device_id = R::store($device);
				
				redirect('/devices/calibrate/' . $device_id);
			} catch (Exception $e) {
				$error = $e->getMessage();
			}
		}
		
		$title = 'Add Device';
		$this->load->view('devices/add', compact('countries','device','address','error','title'));
	}
	
	function edit($id = false)
	{
		$this->auth->action('edit', 'device');
		if (!$id) redirect('/devices');
		$error = false;
		$device = R::load('device', $id);
		$address = $device->address;
		$countries = R::find('country', '1 ORDER BY name');

		$device_groups = $this->device_m->get_device_groups();
		$device_codes = $this->device_m->get_device_codes();
		
		if ($this->input->post()) {
			try {
				$device->import($this->input->post(), 'name,location,max_code_reuse,calibration,calibration_date');
				$device->address->import($this->input->post('address'), 'line_1,line_2,city,postcode,country_id');
				R::store($device);
				
				redirect('/devices');
			} catch (Exception $e) {
				$error = $e->getMessage();
			}
		}
		$title ='Edit Device';
		$this->load->view('devices/edit', compact('device','address','countries','error','title','device_groups','device_codes'));
	}
	
	function delete($id=false)
	{
		$this->auth->action('delete', 'device');
		if (!$id) redirect('/devices');
		$device = R::load('device', $id);
		if (!$device->id) show_404();
		
		if ($data = $this->input->post()) {
			$device = R::load('device', $data['id']);
			R::trash($device);
			$this->session->set_flashdata('message', 'Device deleted successfully');
			redirect('/devices');
		}
		$title = 'Delete Device';
		$this->load->view('devices/delete', compact('device','title'));
	}
	
	function calibrate($device_id)
	{
		$this->auth->action('calibrate', 'device');
		$device = R::load('device', $device_id);		
		//if ($device->account_id != $this->user->account->id) $this->auth->access_restricted();
		$title = 'Device Calibration';
		$this->load->view('devices/calibrate', compact('device','title'));
	}
	
	function calibration_complete()
	{
		$title = 'Calibration Complete';
		$this->load->view('devices/calibrate_complete', compact('title'));
	}
	
	function calibrate_error()
	{
		$title = 'Calibration Erorr';
		$this->load->view('devices/calibrate_error',compact('title'));
	}
	
	// this effectively initialises the device, setting it's initial timecode and timestamp
	function get_reg_string($device_id)
	{
		try {
			// todo - might be nice to put a custom error handler in to catch *all* php errors and return them via json
			
			require APPPATH . 'libraries/JsonResponse.php';
			
			$device = R::load('device', $device_id,'calibration,calibration_date');
			if (!$device) throw new Exception('Device not found');
			// todo - check ownership
			
			$this->load->library('encryption');
			
			// You provide these 3 values. These are just examples for testing
			$key = $device->account->secret_key;
			$initial_timecode = $this->encryption->createRandomTimecode(); // create a new initial timecode, random and save it in db, along with the initial timestamp
			
			// AS use $response and $error_code which are received references which can be checked when function completes
			if(!$this->encryption->getDevRegistrationStr($reg_string, $key, $device_id, $initial_timecode, $error_code))
			{
				switch($error_code)
				{
					case ENC_ERR_4:
						throw new Exception('Invalid Key');
						break;
					// todo - either log the error, as above, or add it to response and modify basic-add-device.htm to use it
				}
			}
			
			// save our newly created intial timestamp and code
			$device->initial_code = $initial_timecode;
			$device->calibration = 1;
			$device->initial_time = date("Y-m-d H:i:s");    // store the initial time (will need to be changed to UTC)
			R::store($device);
			
			$response = new JsonResponse('ok', array('reg_string'=>$reg_string));
			
			
		} catch (Exception $e) {
			$response = new JsonResponse('error', array($e->getMessage()));
		}
		
		$response->display();
	}
	function device_search()
	{
		$this->load->model('device_m');
		$device = R::load('device', $id);
		$address = $device->address;
		$countries = R::find('country', '1 ORDER BY name');

		$title = 'Device Search';
		if ($this->input->post('term')){
			$result = $this->device_m->search($this->input->post('term'));
			$this->load->view('devices/search',compact('title','result','device','address','countries'));

			$search_session = array(
				'term'	 => $this->input->post('term'), // Grabs the term entered so it can be matched if required
				'search_result' => $result // Stores the searched term & it's data into a session for quick use
			);
			$this->session->set_userdata($search_session);

		}
		else{
			//redirect('program/index','refresh');
		}
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
			
			// check that the time is not before the device was set up
			$earliest_date = new DateTime($device->initial_time);			
			if ($date < $earliest_date) throw new Exception('<span class="txt-alert">Oops, that\'s an invalid code</span>');
			
			return $date;
			
		} 
		else {
			log_message('debug', 'Code could not be converted to time: ' . $error_code);
			throw new Exception('Oops that code is not valid, please try again');
			
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
			$low_batt = $payload->getLowBattery(); // Low Battery Function
			$device = R::load('device', $device_id);
			return $device;
			
		} else {
			log_message('debug', 'Code could not be related to a device: ' . $error_code);
			throw new Exception('Invalid code - device not found');
		}
		
	}
	// validates a code passed as the 3rd segment of the url
	function validate($code='', $account_id=false)
	{
		$valid = true;
		$reason = '';
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
			$reason = $time_string;
			$valid = true;
		} catch (Exception $e) {
			$valid = false;
			$reason = $e->getMessage();
		}
			

		$result = array('valid'=>$valid, 'reason'=>$reason, 'device'=>$device);
		if ($this->input->is_ajax_request()) {
			echo json_encode($result);
			exit;
		} else {
			return $result;
		}
		
		//return $result;
		
	}
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
	
	function check($code='')
	{
		$error = false;
		$this->form_validation->set_rules('single','lang:single_code','required|max_length[8]|min_length[8]|trim|is_unique[code.code]');
		$submitted = $this->input->post('submit');
		$code = $this->input->post('single');
		$id = $this->uri->segment(4); 

		$get_device = $this->check_model->get_device_name(); // Model for getting Device name based on URI segment
		$allCodes = $this->check_model->code_all();
		$deviceid = $this->session->set_userdata($this->uri->segment(4));
		$account = $this->session->userdata('account_id');
	
		if ($data = $this->input->post()) {
			
			try {
				
				// validation & prep
				$codes = array();
				
				if (!empty($data['singles'])) foreach ($data['singles'] as $i => $line) {
					$code = trim(strtoupper($line['code']));
					
					
					$result = $this->validate($code, $account);
					if (!$result['valid']) continue;
					$codes[] = array(
						'code'=>$code, 'type'=>'single'
					);
					
				}
				$ca = $this->session->set_userdata('ca',$codes);
				$this->session->set_userdata('result', $result);
				//var_dump($codes);
				//if (empty($codes)) throw new Exception('No valid codes were entered or empty');
				
				// if no errors so far, we have passed validation
				// now save them
				$this->save_code($code, $account);
				
			} catch (Exception $e) {
				$error = $e->getMessage();	
			}
			
			//if (!$error) redirect('devices/checked', $result);
		}
			// title for page
			$title = 'Enter Codes';
			$devices = $this->account->ownDevice;

			$deviceName = $this->check_model->get_device_name();

			$uri_string = $this->session->userdata('uri');
			$this->load->view('devices/check', compact('uri_string','error','title','uri_string','id','devices','account','deviceName','result','codes','code','get_device'));
		
		
	
	}
	
	function checked($code ='')
	{		
		$devices = $this->account->ownDevice;
		$this->load->database();
		
		$data = array();
		$error = false;
		$format = 'j M Y - H:i';
		$rc = $this->session->unset_userdata('recent_code_ids');
		$code = $this->input->post('single');
		$device_id = $this->uri->segment(4); 
		
		$get_device = $this->check_model->get_device_name(); // Model for getting Device name based on URI segment
		$allCodes = $this->check_model->code_all();
		
		$temp_device_id = $this->session->userdata('temp_device_id');
		$temp_account_id = $this->session->userdata('temp_account_id');
		$temp_code = $this->session->set_userdata('temp_code', strtoupper($code));
		
		$title = 'Device Checked';
		$this->load->view('devices/checked', compact('title','code','data','rc','device_id','temp_code','devices','get_device'));
	}

	function update_offset($message ='')
	{
		
		$user_update = $this->input->post('new_date');
		$time_updated = $this->session->userdata('input_date');

		$code = $this->input->post('single');
		$device_id = $this->uri->segment(4); 
					
		//var_dump($this->session->userdata('temp_code'));
		$last = $this->db->insert_id();
		
		$update_array = array(
			'code' => $this->session->userdata('temp_code'),
			'time' => $time_updated,
			'batch_ref' => $this->generate_batch_reference(),
			'temp_code' => '',
			'added_at' => $user_update
		);
		$this->db->set($update_array, true);
		$this->db->where('id', $last);
		$this->db->update('code');
		
		if ($user_update != '') {
					
			$this->db->set('offset_time', $user_update, true);
			$this->db->where('id', $this->uri->segment(3));
			$this->db->update('device');

		}
		$update_success = $this->session->set_userdata('update_success','<strong>Success</strong><br />New time &amp; date has been successfully saved.');
		$title = 'Update Successful';
		$this->load->view('devices/offset_update',compact('update_success','title'));

	}
	function records_matched()
	{
	
		$update_success = $this->session->set_userdata('update_success','Thank you, this process is now complete.');
		$title = 'Update Successful';
		$this->load->view('devices/records_matched',compact('update_success','title'));

	}
	
	public function export(){
		$this->load->helper('download');
    	$this->load->dbutil();
    	$account_id = $this->session->userdata('account_id');
    	
    	$Q = $this->db->query("SELECT code, time, duration, batch_ref, device_id FROM code WHERE account_id = $account_id LIMIT 0 , 10");
    	$csv_return = $this->dbutil->csv_from_result($Q,",","\n");
		force_download('Multiple-Upload__Account No-'.$account_id.'.csv', $csv_return); 
 	}
	// Upload csv doc
	public function upload_step_1()
	{
		$title = 'Template Download';
		$this->load->view('devices/upload_step_1', compact('title'));
	}
	// Upload of bulk devices/codes etc
	public function do_upload()
	{
		$csv_path = realpath(APPPATH . '/../assets/uploads/');
		$config['upload_path']   = $csv_path;
		$config['allowed_types'] = '*'; // All types of files allowed
		$config['overwrite']     = true; // Overwrites the existing file
		  
		$this->upload->initialize($config);
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('userfile'))
		{
			$error = $this->upload->display_errors();
			$title = "There was an error";
			$this->load->view('devices/upload_step_1', compact('error','title'));
		}
		else
		{
			$table = 'code';
			$image_data = $this->upload->data();
    		$fname = $image_data['file_name'];
    		$fpath = $image_data['file_path'].$fname;
    		$fh = fopen($fpath, "r+");
    		$headers = 0;
			
			$insert_str = 'INSERT INTO code (code, time, duration, batch_ref, device_id) VALUES '."\n";
			

			if ($fh && $headers == 0) {
	            // Create each set of values.
	            while (($csv_row = fgetcsv($fh, 3000, ',')) !== FALSE) {

	                foreach ($csv_row as &$row) {
	                    $row = strtr($row, array("'" => "\\'", '"' => '\\"'));
	                }

	                $insert_str .= '("'
	                    // Implode the array and fix pesky apostrophes.
	                    .implode('","', $csv_row)
	                    .'"),'."\n";
	            
	            }

	            // Remove the trailing comma.
	            $insert_str = rtrim($insert_str, ",\n");

	            // Insert all of the values at once.
	            $this->db->query($insert_str);
		        $title = 'Upload File';
	            $this->load->view('devices/upload_complete', compact('title'));
			
	        } 		
		}
	}

	public function upload_complete()
	{
		$title = 'Upload Successful';
		$this->load->view('devices/upload_complete', compact('title'));
	}
	public function group_device()
	{
		$user = $this->session->userdata('account_id');
		$this->device_m->save_device_group();
		$this->session->set_flashdata('message','Group successfully saved');
		redirect('devices');
	}
	public function delete_group($id)
	{
		$this->device_m->delete_group($id);
		$this->session->set_flashdata('message','Device group successfully removed');
		redirect('devices');
	}
	private function _gen_pdf($html,$paper='A4')
    {
        $this->load->library('mpdf/mpdf'); // Load mPDF library
        
        $company = $this->account->company_name; // Grabs company name
        $acc = $this->account->account_number; // Grabs account number
        $gen = $company.' Codes Report'; // Stores company name and account number
        
                       
        $mpdf=new mPDF('utf-8', 'A4');
        $mpdf->setFooter('These times have been verified by Clockin Point | www.clockinpoint.com | {PAGENO}');
        $mpdf->SetWatermarkImage('images/summary-sheet-bg.png');
		$mpdf->showWatermarkImage = true;
		$mpdf->watermarkImageAlpha = 0.2;
        $mpdf->WriteHTML($html);
        
        $mpdf->Output($gen.'.pdf','D');
    } 
	public function run_report($pdf = false)
	{
		$title = 'Reporting';
		ini_set('memory_limit', '-1');
		
		$html = $_REQUEST['html'];
		//error_reporting(E_ALL);
		
		$this->load->helper('date');
		$rand_number = strtoupper(random_string('alnum', 7));
		$codes = $this->device_m->get_device_codes();
		
		$root = dirname(__FILE__).'/../../';
		$html = $this->load->view('pdf/code_report', compact('html','root','title','rand_number','codes'), true);
		$this->_gen_pdf($html); 

	}
}