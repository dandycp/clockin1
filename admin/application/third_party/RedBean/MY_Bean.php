<?php 

class MY_Bean extends RedBean_SimpleModel 
{
	
	// provices an indexed alternative to RedBean's own "->ownObject" method
	public function own($object) 
	{
		$method = 'own' . ucfirst($object);
		$children = array_values($this->{$method});
		return $children;
	}
}