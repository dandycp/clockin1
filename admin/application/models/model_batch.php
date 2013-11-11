<?php 

class Model_Batch extends CI_Model {

	private $_ref;
	
	/**
	 * Initialises the model with a batch reference code
	 *
	 * @param string $batch_ref The batch reference code
	 * @return void
	 */
	public function init($batch_ref) 
	{
		$this->_ref = $batch_ref;
	}
	
	/**
	 * Returns all the codes that make up this batch
	 *
	 * @return array
	 */
	public function get_codes()
	{
		$codes = R::find('code', 'batch_ref=? ORDER BY end_time DESC', array($this->_ref));
		return $codes;
	}
	
	/**
	 * Returns the total duration in seconds of all the code entries in this batch
	 *
	 * @return int
	 */
	public function total_duration()
	{
		$duration = 0;
		$codes = $this->get_codes();
		if (!$codes) return $duration;
		
		foreach ($codes as $code) {
			$duration+= $code['duration'];
		}
		
		return $duration;
	}
	
}