<?php 

class Model_Device extends MY_Bean 
{	
	public function open()
	{
		
	}
	
	public function update() 
	{

		if (empty($this->name)) throw new Exception('Device Name is required');

		if (empty($this->location)) throw new Exception('Location is required');

		$names = $this->name;
		$existing_name = R::findOne('device', 'name=? AND id<>?', array($names, $this->id));
		if ($existing_name) throw new Exception('The device name is already in use, please try another name');

	}


}
