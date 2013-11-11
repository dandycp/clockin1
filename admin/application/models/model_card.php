<?php 

class Model_Card extends MY_Bean 
{	
	public function has_expired()
	{
		$tomorrow = new DateTime('tomorrow');
		$card_expires = new DateTime($this->expires);
		return $card_expires <= $tomorrow ? true : false ;	
	}
	
	public function get_expiry_date()
	{
		// show a friendly version of our expiry date
		$date = $this->expires;
		return date("F Y", strtotime($date));
	}
}
