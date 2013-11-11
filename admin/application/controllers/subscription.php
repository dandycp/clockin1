<?php 

class Subscription extends MY_Controller
{
	
	// get the price of a subscription
	function get_price()
	{
		$type = $this->input->get('type');
		$devices = $this->input->get('device_limit');
		
		$valid = true;
		$message = '';
		$price = 0;
		
		if (!$type) {
			$valid = false;
			$message = 'Account type not specified';
		} 
		else if (!$devices) {
			$valid = false;
			$message = 'Number of devices not specified';
		}
		else if ($type == 'basic' && $devices > 1) {
			$valid = false;
			$message = 'Basic packages can only support 1 device';
		}
		else if ($type == 'basic' && $devices == 1) {
			$price = 0;	
		}
		else {
			
			// calculate the cost
			try {
				$this->load->model('model_pricing', 'pricing');
				$price = $this->pricing->get_price($devices, 'year');
			} catch (Exception $e) {
				$valid = false;
				$message = $e->getMessage();	
			}
				
		}
		
		$result = array('valid'=>$valid, 'message'=>$message, 'price'=>$price);
		
		if ($this->input->is_ajax_request()) {
			echo json_encode($result);
			exit;
		} else {
			return $result;
		}
		
	}
	
}