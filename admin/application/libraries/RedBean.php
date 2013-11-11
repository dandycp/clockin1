<?php 

class RedBean { 

	function __construct() { 
		
		// Include database configuration 
		include(dirname(__FILE__).'/../config/database.php'); 
		
		// Get Redbean 
		require_once(dirname(__FILE__).'/../third_party/RedBean/rb.php'); 
		
		// Get custom Bean class
		require_once(dirname(__FILE__).'/../third_party/RedBean/MY_Bean.php'); 
		
		// Database data 
		$host = $db[$active_group]['hostname']; 
		$user = $db[$active_group]['username']; 
		$pass = $db[$active_group]['password']; 
		$db = $db[$active_group]['database']; 
		
		// Setup DB connection 
		R::setup("mysql:host=$host;dbname=$db", $user, $pass); 
		
		// Setup our custom mapping
		//include(APPPATH.'/third_party/RedBean/MyBeanFormatter.php'); 
		//R::$writer->setBeanFormatter(new MyBeanFormatter);
		R::freeze(true); //will freeze redbeanphp
		
	} //end __contruct() 
	
} //end Rb
