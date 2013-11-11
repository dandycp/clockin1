<?php
// v2.0
interface IPayload
{
	function __construct($device_id, $timecode, $low_battery, $lsfC, $lsfD);

	public function getDeviceId();
	public function getDateTime($initial_timecode, $initial_datetime);
	public function getLowBattery();
}

class Payload implements IPayload
{
	private $device_id;
	private $timecode;
	private $low_battery;
	private $lsfrC;
	private $lsfrD;
	
	function __construct($device_id, $timecode, $low_battery, $lsfrC, $lsfrD)
	{
		$this->device_id = $device_id;
		$this->timecode = $timecode;
		$this->low_battery = $low_battery;
		$this->lsfrC = $lsfrC;
		$this->lsfrD = $lsfrD;
	}
	
	public function setDeviceId($device_id)
	{
		$this->device_id = $device_id;
	}
	
	public function setTimecode($timecode)
	{
		$this->timecode = $timecode;
	}
	
	public function setLowBattery($low_battery)
	{
		$this->low_battery = $low_battery;
	}

	public function getDeviceId()
	{
		return $this->device_id;
	}
	
	public function getDateTime($initial_timecode, $initial_timestamp)
	{
		// $initial_timecode is a seed - expand it
		$initial_timecode ^= 0x397338;
		$initial_timecode ^= ($this->lsfrC[0] ^ ($this->lsfrC[1] << 8) ^ ($this->lsfrC[2] << 16));
		$initial_timecode ^= ($this->lsfrD[0] ^ ($this->lsfrD[1] << 8) ^ ($this->lsfrD[2] << 16));
		
		// echo 'TC1: ' . $initial_timecode . '<br>';

		// deal with timecode rollover
		while($initial_timecode > $this->timecode)
			$this->timecode += pow(2, 22);
		
		// echo 'TC2: ' . $initial_timecode . '<br>';
		
		$mins = ($this->timecode - $initial_timecode); // * 2;

		// echo 'mins: ' . $mins . '<br>';
		
		$date = new DateTime();
		$date->setTimestamp($initial_timestamp + $mins * 60);

		return $date;
	}
	
	public function getLowBattery()
	{
		return $this->low_battery;
	}
}

?>