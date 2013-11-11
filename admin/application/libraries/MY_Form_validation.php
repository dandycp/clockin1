<?php 

/**
 * Form Validation Class - extends the default CodeIgniter one so we can get the error messages back in a more sensible fashion
 */
class MY_Form_validation extends CI_Form_validation {

	/**
	 * Constructor
	 */
	public function __construct($rules = array())
	{
		parent::__construct($rules);
	}
	
	public function get_errors() 
	{
		return $this->_error_array;
	}

}
// END Form Validation Class
