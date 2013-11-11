<?php 

class Model_Code extends MY_Bean 
{
	
	public function open()
	{
		$this->add_aliases();
	}
	
	// add custom properties
	private function add_aliases()
	{
	}
	
	public function category_name()
	{
		return ($this->category) ? $this->category->name : '';
	}
	
	public function person_name()
	{
		return ($this->person) ? $this->person->name : '';
	}
	
	private function remove_aliases()
	{
		
	}
	
	public function update() 
	{
		if (empty($this->code)) throw new Exception('Code is required');
		elseif (strlen($this->code) != 8) throw new Exception('Code must be 8 characters in length');
		if (empty($this->type)) throw new Exception('Type is required');
		if (!preg_match('/[a-z0-O]{8}/i', $this->code)) throw new Exception('Only characters A-Z and 0-9 allowed');
		$this->code = strtoupper($this->code);
		
		// calculate duration for where there is a start and end code
		if (!empty($this->end_time)) {
			$t1 = new DateTime($this->time);
			$t2 = new DateTime($this->end_time);
			$seconds = $t2->getTimestamp() - $t1->getTimestamp();
			$this->duration = $seconds;
		} else {
			$this->duration = 0;	
		}
		
		// remove our temporary properties
		$this->remove_aliases();
	}
	
	public function after_update()
	{
		// recreate any custom aliases (properties)
		$this->add_aliases();	
	}
	
	public function format_time($format)
	{
		return date($format, strtotime($this->time));	
	}
}
