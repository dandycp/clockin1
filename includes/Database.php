<?php
class Database {

	//class variables defined in constructor
	var $host;
	var $user;
	var $password;
	var $database;
	var $show_errors;
	private $debug = false;
	private $conn;
	
	function Database() {
		// check if we're live or not
		if (stristr($_SERVER['HTTP_HOST'], 'local')) {
			$this->host = 'localhost';
			$this->database = 'clockin';
			$this->user = 'root';
			$this->password = 'root';
			$this->show_errors = TRUE;
		} else {
			$this->host = 'localhost';
			$this->database = 'web4-clocksite';
			$this->user = 'web4-clocksite';
			$this->password = 'UTV!7fm^t';
			$this->show_errors = TRUE;
		}
		$this->conn = mysql_connect($this->host, $this->user, $this->password) or exit;
		mysql_select_db ($this->database, $this->conn);
		mysql_query("SET NAMES utf8", $this->conn); // todo - remove and use mysql variables set on server instead
	}
  
	// Makes a value safe for insertion into db
	function safe($value) 
	{
		// Stripslashes
		if (get_magic_quotes_gpc()) $value = stripslashes($value);
		
		// Quote if not a number or a numeric string or begins with '0' - eg a mobile number, and is not the reserved 'NULL' value
		if ((!preg_match('/^[0-9\.]*$/',strval($value)) || (strlen($value)>1 && $value[0] == "0")) && $value!=="NULL") {
			$value = "'" . mysql_real_escape_string($value) . "'";
		}
	
		return $value;
	}
  
	//loop through array building an sql INSERT statement
	function insert($data, $table) 
	{	
		$data = $this->remove_invalid_fields($data, $table);
    	$fields  = "";
		$values = "";
		
		foreach ($data as $f => $value)	{			
			$fields  .= "`$f`,";
			
			// make the value safe for insertion
			$value = $this->safe($value);
			
			// if value is NULL or FALSE, return a string containing the word 'NULL' can actually be inserted into database
			if ($value === NULL || $value === FALSE) $value = 'NULL';
			
			// if an empty string, return a quoted empty string
			if ($value === '') $value = "''";
			
			$values .= $value.",";
			
			
		}
		
		$fields = rtrim($fields, ', ');
    $values = rtrim($values, ', ');
    	
		$insert = "INSERT INTO `$table` ($fields) VALUES($values)";
		$id = $this->execute_query($insert, true);
		return $id;
	}

	//loop through paired arrays buildng an sql UPDATE statement
	function update($table, $data, $condition='') 
	{
		$data = $this->remove_invalid_fields($data, $table);
		
		$sql = "UPDATE `$table` SET ";
		foreach ($data as $key => $value) 
		{
			// make the value safe for insertion
			$value = $this->safe($value);
			
			// if value is NULL or FALSE, return a string containing the word 'NULL' can actually be inserted into database
			if ($value === NULL || $value === FALSE) $value = 'NULL';
			
			// if an empty string, return a quoted empty string
			if ($value === '') $value = "''";
		
			$sql.= "`$key`=" . $value . ", ";
		}
		// remove the last comma and add user's condition
		$sql = rtrim($sql,', ') . ' ' . $condition;
		return $this->execute_query($sql);
	}
  
	// delete a single row from a table
	function delete($table, $where) 
	{
		return $this->execute_query("DELETE FROM `$table` $where");
	}
	
	// get a single cell from a table
	function get_cell($cell, $table, $where='') 
	{
		return $this->query("SELECT `$cell` FROM `$table` $where LIMIT 1", "cell");
	}
	
	// get a single row from a table
	function get_row($table, $where='') 
	{
		return $this->query("SELECT * FROM `$table` $where LIMIT 1", "row");
	}
	
	// get all entries from a table
	function get_all($table, $where='') 
	{
		return $this->query("SELECT * FROM `$table` $where", "table");
	}

	// execute a query that doesn't return a result (eg. insert, update etc)
	function execute_query($query,$returnid=false, $close=true)
	{
		$result = mysql_query($query, $this->conn);
		
		// display error if we return no result
		if (!$result && $this->show_errors) throw new Exception("Invalid query: " . mysql_error() . " - Whole query: " . $query);
		
		// find a last insert id if one was requested
		$outcome = $returnid ? mysql_insert_id($this->conn) : $result;
		
		unset($result);
	
		return $outcome;
	}
  
	// this query function will return the result in a number of useful ways - cell, row, table or just result
	function query($q,$format='result') 
	{
		if ($this->debug) {
			echo '<br/><pre style="background:white; color:red; display:inline-block; padding:2px 4px;">'.$q.'</pre><br/>';
			ob_flush();
		}
		$result = mysql_query($q, $this->conn);
			if (is_resource($result)) {
				if (mysql_num_rows($result)>0) {
					switch ($format) {
						case "cell" :
							$output = mysql_result($result,0);
							break;
						case "row" :
							$output = mysql_fetch_array($result,MYSQL_ASSOC);
							break;
						case "table" :
							while($row = mysql_fetch_array($result,MYSQL_ASSOC)) $table[] = $row;
							$output = $table;
							break;
						default :
							$output = $result;
							break;
					}
				} else {
					$output = false;
				}
			} else {
				if ($this->show_errors) throw new Exception("Invalid query: " . mysql_error() . '<br />Whole query: ' . $q);
				return FALSE;
			}
		unset($result);

		return $output; 
	}
	
	// returns an array of empty variables that match the columns in a table - useful for initial data on an add/edit form
	function get_empty_fields($table) 
	{
		$result = $this->query("DESCRIBE `$table`","table");
		if (!empty($result)) foreach ($result as $row) $fields[$row['Field']] = '';
		return $fields;
	}
	
	// remove any array items not valid for a particular table
	function remove_invalid_fields($data, $table) 
	{
		$fields = $this->get_empty_fields($table);
		foreach ($data as $field=>$value) if (!array_key_exists($field, $fields)) unset($data[$field]);
		return $data;
	}

}
?>