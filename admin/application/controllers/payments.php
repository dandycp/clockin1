<?php 

class Payments extends MY_Controller {

	function add_card()
	{
		if (!$this->auth->is_logged_in()) $this->auth->access_restricted();
		$error = false;
		$this->load->helper('card');
		
		$card = new StdClass();
		$card->number = '';
		$card->type = '';
		$card->name = '';
		$card->csc = '';
		$card->expires_m = '';
		$card->expires_y = '';
		
		if ($data = $this->input->post()) try {
			
			// populate our card object
			$card->number = $data['number'];
			$card->type = $data['type'];
			$card->name = $data['name'];
			$card->csc = (int) $data['csc'];
			$card->expires_m = (int) $data['expires_m'];
			$card->expires_y = (int) $data['expires_y'];
			
			// some validation
			$card_number = str_replace(' ', '', $card->number);
			if (!card_number_valid($card_number)) throw new Exception('Card number is not valid');
			if (!card_expiry_valid($card->expires_m, $card->expires_y)) throw new Exception('Card has expired');
			if ($card->csc > 999 || $card->csc < 100) throw new Exception('Security code must be 3 digits in length');
			
			// some prep
			$card->number = card_number_clean($card->number);
			
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
			
			$transaction = R::dispense('transaction');
			$transaction->transactiontype_id = 3; // initial card registration
			$transaction->account_id = $this->account->id;
			$transaction->amount = 0;
			$transaction->notes = "Initial card registration";
			R::store($transaction);
			
			$order_id = rand(1,100000);
			$params = array(
				'card_no' => $card->number,
				'name' => $card->name, 
				'card_type' => $card->type, 
				'exp_month' => substr('0' . $card->expires_m, -2), 
				'exp_year' => $card->expires_y, 
				'csc' => $card->csc,
				'currency' => $config['currency'],
				'transaction_id' => $transaction->id
			);
			
			//$response = $this->merchant->purchase($params);
			$response = $this->merchant->tokenise($params);
			
			if ($response->status() == Merchant_response::COMPLETE) {
				$token = $response->get_token();
				
				$card_on_file = R::dispense('card');
				$card_on_file->type = $card->type;
				$card_on_file->account_id = $this->account->id;
				$card_on_file->token = $token;
				$card_on_file->last_4_digits = substr($card->number, -4);
				$card_on_file->expires = card_expiry_date($card->expires_m, $card->expires_y);
				R::store($card_on_file);
				
				$transaction->success = 1;
				$transaction->gateway_ref = $response->status();
				$transaction->gateway_message = $response->message();
				R::store($transaction);
				
				redirect('/payments/card_complete');
				
			} else {
				
				// todo - store failure information from gateway
				$transaction->gateway_ref = $response->status();
				$transaction->gateway_message = $response->message();
				R::store($transaction);
				
				$error = $response->message();	
				
			}			
			
		} catch (Exception $e) {
			$error = $e->getMessage();	
		}
		
		// reset a couple of things
		if ($card->expires_m == 0) $card->expires_m = '';
		if ($card->expires_y == 0) $card->expires_y = '';
		if ($card->csc == 0) $card->csc = '';
		$title = 'Add Card';
		$this->load->view('payments/add_card', compact('error','card','title'));
	}
	
	function card_complete()
	{
		$this->load->view('payments/card_complete');
	}
	
	// run our (nightly) process to see if anyone needs to pay
	function process()
	{
		// find all one-off payments which haven't been made yet
		$query = "
			SELECT * FROM subscription AS s 
			WHERE active = 1 AND initial_amount > 0 AND s.id NOT IN (
				SELECT subscription_id FROM transaction AS t
				WHERE t.transactiontype_id = 2 AND success = 1
				)
			";
		$rows = R::getAll($query);
		if (!empty($rows)) {
			$one_off_subscriptions = R::convertToBeans('subscription', $rows);	
		}
		
		// find all subscriptions where payment is due today
		$query = "
			SELECT * FROM subscription AS s 
			WHERE active = 1 AND amount > 0 AND next_payment_due <= CURDATE() AND s.id NOT IN (
				SELECT subscription_id FROM transaction AS t
				WHERE t.transactiontype_id = 1 AND success = 1
				)
			";
		$rows = R::getAll($query);
		if (!empty($rows)) {
			$regular_subscriptions = R::convertToBeans('subscription', $rows);	
		}
		
		
		// now charge our customers
		$this->load->model('model_payment','payment');
		if (!empty($one_off_subscriptions)) foreach ($one_off_subscriptions as $subscription) {
			$amount = $subscription->initial_amount;
			$account = $subscription->account;
			$card = $account->get_card();
			if (!$card) {
				error_log('Card not found for customer: ' . $account->name);
				continue;
			}
			$transactiontype_id = 2; // our initial payment code
			$description = 'Clock In Point initial payment';
			$this->payment->charge_card($card, $amount, $transactiontype_id, $description, $subscription->id);
		}
		
		if (!empty($regular_subscriptions)) foreach ($regular_subscriptions as $subscription) {
			$amount = $subscription->amount;
			$account = $subscription->account;
			$card = $account->get_card();
			if (!$card) {
				error_log('Card not found for customer: ' . $account->name);
				continue;
			}
			$transactiontype_id = 1; // our regular subscription payment code
			$description = 'Clock In Point subscription';
			$this->payment->charge_card($card, $amount, $transactiontype_id, $description, $subscription->id);
		}
	}

}