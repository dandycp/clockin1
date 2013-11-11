<?php 

class Model_Pricing extends CI_Model {

	public function get_price($num_units, $interval='year')
	{
		$price = R::findOne('price', "num_units <= ? ORDER BY num_units DESC", array($num_units));
		
		if (!$price) {
			// if a price hasn't been found, they are probably below the lowest specified number of units
			// - just give them the lowest qty price we have available
			$price = R::findOne('price', "1 ORDER BY num_units ASC");
			if (!$price) throw new Exception('Could not find price for this request');
		}
		
		$field = 'per_unit_per_' . $interval;
		if (!isset($price->$field)) throw new Exception('Price interval is not valid');
		
		$amount = round($price->$field * $num_units, 2);
		
		return $amount;
	}
	
}
