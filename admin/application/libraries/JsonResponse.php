<?php 

class JsonResponse {
	
	public $status; // ok|error
	public $data;
	public $errors;
	
	function __construct($status, $data) 
	{
		$this->status = $status;
		if ($status == 'ok') $this->data = $data;
		else $this->errors = $data;
	}
	
	function display()
	{
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		
		$json_string = json_encode($this);
		echo $json_string;
		exit;
	}
		
}