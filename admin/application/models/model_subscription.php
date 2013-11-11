<?php 

class Model_Subscription extends MY_Bean {
	
	private function is_leap_year($year)
	{
		$result = date("L", mktime(1,1,1,1,1, $year));
		return ($result == 1) ? true : false ;
	}
	
	public function fraction_used()
	{
		$start = strtotime($this->added_at);
		$end = strtotime($this->next_payment_due);		
		$now = time();

		$seconds_used = max(0, $now - $start);
		$seconds_left = max(0, $end - $now);
		$total_seconds = $seconds_used + $seconds_left;
		
		$fraction = $seconds_used / $total_seconds;
		
		return $fraction;
		
	}
	
	public function fraction_left()
	{
		$fraction = 1 - $this->fraction_used();
		return $fraction;
	}
	
	public function update() 
	{
		// add next payment date, based on interval (days) field
		if (!$this->id) {
			$this->next_payment_due = date("Y-m-d", strtotime("NOW + 1 year"));
			$this->added_at = date("Y-m-d H:i:s");
		}
	}
	
}