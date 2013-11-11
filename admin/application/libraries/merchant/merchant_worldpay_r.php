<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * CI-Merchant Library
 *
 * Copyright (c) 2011-2012 Adrian Macneil
 *
 */

/**
 * Merchant WorldPay Class (With Recurring billing) (c) 2013 - Andy Coates
 *
 * Payment processing using WorldPay (external)
 * Documentataion: http://www.worldpay.com/support/kb/bg/htmlredirect/rhtml.html
 */

class Merchant_worldpay_r extends Merchant_driver
{
	const PROCESS_URL = 'https://secure.worldpay.com/wcc/purchase';
	const PROCESS_URL_TEST = 'https://secure-test.worldpay.com/wcc/purchase';
	const IADMIN_URL = 'https://secure.worldpay.com/wcc/iadmin';

	public function default_settings()
	{
		return array(
			'installation_id' => '',
			'secret' => '',
			'payment_response_password' => '',
			'test_mode' => FALSE,
		);
	}
	
	public function _do_cancel_agreement($params)
	{
		$gateway_ref = (isset($params['gateway_ref'])) ? $params['gateway_ref'] : false ;
		if (!$gateway_ref) throw new Exception('gateway_ref not set');
		
		$request = array();
		$request['instId'] = $this->setting('installation_id');
		$request['authPW'] = $this->setting('auth_password');
		$request['futurePayId'] = $gateway_ref;
		$request['op-cancelFP'] = true;
		
		// post our details off to worldpay and check the response
		$this->CI->load->library('curl');
		// Start session (also wipes existing/previous sessions)
		$this->CI->curl->create(self::IADMIN_URL);
		$this->CI->curl->option(CURLOPT_SSL_VERIFYPEER, false);
		$this->CI->curl->post($request);
		$response = $this->CI->curl->execute();
		
		
		echo '<pre>'; var_dump($response); 
		
		var_dump($this->CI->curl->error_string);

		// Information
		var_dump($this->CI->curl->info); // array
		
		exit;	
	}

	public function purchase()
	{
		$request = array();
		
		$request['instId'] = $this->setting('installation_id');
		$request['cartId'] = $this->param('order_id');
		$request['desc'] = $this->param('description');
		$request['amount'] = $this->amount_dollars();
		$request['currency'] = $this->param('currency');
		$request['testMode'] = $this->setting('test_mode') ? 100 : 0;
		$request['MC_callback'] = $this->param('return_url');
		$request['name'] = $this->param('name');
		$request['address1'] = $this->param('address1');
		$request['address2'] = $this->param('address2');
		$request['town'] = $this->param('city');
		$request['region'] = $this->param('region');
		$request['postcode'] = $this->param('postcode');
		$request['country'] = $this->param('country');
		$request['tel'] = $this->param('phone');
		$request['email'] = $this->param('email');

		if ($this->setting('secret'))
		{
			$request['signatureFields'] = 'instId:amount:currency:cartId';
			$signature_data = array($this->setting('secret'),
				$request['instId'], $request['amount'], $request['currency'], $request['cartId']);
			$request['signature'] = md5(implode(':', $signature_data));
		}
		
		$this->redirect($this->_process_url().'?'.http_build_query($request));
	}

	public function purchase_return()
	{
		$callback_pw = (string)$this->CI->input->post('callbackPW');
		if ($callback_pw != $this->setting('payment_response_password'))
		{
			return new Merchant_response(Merchant_response::FAILED, lang('merchant_invalid_response'));
		}

		$status = $this->CI->input->post('transStatus');
		if (empty($status))
		{
			return new Merchant_response(Merchant_response::FAILED, lang('merchant_invalid_response'));
		}
		elseif ($status != 'Y')
		{
			$message = $this->CI->input->post('rawAuthMessage');
			return new Merchant_response(Merchant_response::FAILED, $message);
		}
		else
		{
			$transaction_id = $this->CI->input->post('transId');
			$amount = $this->CI->input->post('authAmount');
			return new Merchant_response(Merchant_response::COMPLETE, NULL, $transaction_id, $amount);
		}
	}
	
	
	public function subscribe()
	{
		$request = array();		
		$request['instId'] = $this->setting('installation_id');
		$request['cartId'] = $this->param('order_id');
		$request['desc'] = $this->param('description');
		$request['amount'] = $this->amount_dollars();
		$request['currency'] = $this->param('currency');
		$request['hideCurrency'] = 1;
		$request['testMode'] = $this->setting('test_mode') ? 100 : 0;
		$request['MC_callback'] = $this->param('return_url');
		$request['name'] = $this->param('name');
		$request['address1'] = $this->param('address1');
		$request['address2'] = $this->param('address2');
		$request['town'] = $this->param('city');
		$request['region'] = $this->param('region');
		$request['postcode'] = $this->param('postcode');
		$request['country'] = $this->param('country');
		$request['tel'] = $this->param('phone');
		$request['email'] = $this->param('email');
		$request['futurePayType'] = 'regular';
		$request['option'] = 0; // can either be 0,1,2. Does anyone really know what it does?
		$request['startDate'] = '';
		
		$frequency = explode(' ', $this->param('frequency')); // in the form "1 year", "3 day"
		$wp_units = array('day'=>1, 'week'=>2, 'month'=>3, 'year'=>4);
		$every = (int) $frequency[0];
		$unit = $wp_units[$frequency[1]];
		
		$request['startDelayMult'] = $every;
		$request['startDelayUnit'] = $unit; // 1 = day, 2 = week, 3 = month, 4 = year
		$request['noOfPayments'] = 0; // (zero = unlimited)
		$request['intervalMult'] = $every;
		$request['intervalUnit'] = $unit; // 1 = day, 2 = week, 3 = month, 4 = year
		$request['normalAmount'] = $this->amount_dollars();
		$request['initialAmount'] = $this->amount_dollars();

		if ($this->setting('secret'))
		{
			$request['signatureFields'] = 'instId:amount:currency:cartId';
			$signature_data = array($this->setting('secret'),
				$request['instId'], $request['amount'], $request['currency'], $request['cartId']);
			$request['signature'] = md5(implode(':', $signature_data));
		}
		
		$url = $this->_process_url().'?'.http_build_query($request);
		$this->redirect($url);
	}
	

	private function _process_url()
	{
		return $this->setting('test_mode') ? self::PROCESS_URL_TEST : self::PROCESS_URL;
	}
}

/* End of file ./libraries/merchant/drivers/merchant_worldpay.php */