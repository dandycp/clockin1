<?php 

class Model_payment extends CI_Model {
	
	public function charge_card($card, $amount, $transactiontype_id, $description='Clock In Point subscription', $subscription_id=false) 
	{	
		$this->load->helper('language');
		$this->lang->load('merchant', 'english');
		$this->load->library('merchant');
		$this->merchant->load('sagepay_direct');
		$this->config->load('sagepay', true);
		$config = $this->config->item('sagepay');			
		$settings = array(
			'vendor'=>$config['vendor'],
			'test_mode'=>$config['test_mode']
		);
		$this->merchant->initialize($settings);	
		$ref = time();
				
		// now let's use our token to pay!
		$params = array(
			'token' => $card->token,
			'store_token' => 1,
			'name' => $card->account->name, // todo - probably change this to name stored in card table 
			'amount' => $amount,
			'currency' => $config['currency'],
			'email'=>$card->account->email,
			'description'=>$description,
			'transaction_id'=>$ref,
			'country'=>'gb'
		);
		
		// log our transaction
		$transaction = R::dispense('transaction');
		$transaction->ref = $ref;
		$transaction->card_id = $card->id;
		$transaction->amount = $amount;
		$transaction->success = 0;
		$transaction->transactiontype_id = $transactiontype_id;
		$transaction->account_id = $card->account_id;
		if ($subscription_id) $transaction->subscription_id = $subscription_id;
		R::store($transaction);
		
		
		$response = $this->merchant->token_purchase($params);
		
		if ($response->status() == Merchant_response::COMPLETE) {
			$transaction->success = 1;
			$return = array('success'=>1, 'message'=>$response->message());
		} else {
			$return = array('success'=>0, 'message'=>$response->message());
		}
		$transaction->gateway_message = $response->message();
		R::store($transaction);
		
		return $return;
	}
}