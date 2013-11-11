<?php 

class Model_Address extends MY_Bean 
{
	public function dispense()
	{
		// set default country to UK
		$this->country_id = 222;
	}
	
	public function full_address()
	{
		$parts = array_filter(array($this->line_1, $this->line_2, $this->city));
		$joined = implode(', ', $parts);
		return $joined;
	}
	
	public function update() 
	{
		if (empty($this->line_1)) throw new Exception('Line 1 of address is required');
		if (empty($this->city)) throw new Exception('City is required');
		if (empty($this->postcode)) throw new Exception('Postcode is required');
		if (empty($this->country_id)) throw new Exception('Country is required');
	}
}