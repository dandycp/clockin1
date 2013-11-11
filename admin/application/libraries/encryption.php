<?php
// v2.0
include_once 'payload.php';

interface IEncryption
{
	// These fncns will return a boolean for success/failure.
	// On success, the result is returned in &$key, &$payload and &$report.
	// On failure, &$error_code is set to one of the error constants.
	public function unpackCipherText($text, $key, &$payload, &$error_code); // was decrypt()
	public function checkBadCipherText($bad_text, $expected_serial, $expected_timestamp, $key, $initial_timecode, $initial_timestamp, $low_battery, $range, &$report, &$error_code);
	public function getDevRegistrationStr(&$response, $key, $device_id, $initial_timecode, &$error_code);	

	public function createRandomKey();
	public function createRandomTimecode();
}

#region constants
// Error codes 
define('ENC_ERR_1', 'Invalid checksum');
define('ENC_ERR_2', 'Invalid plain text');
define('ENC_ERR_3', 'Invalid cipher text');
define('ENC_ERR_4', 'Invalid key');
define('ENC_ERR_5', 'Invalid device ID');
define('ENC_ERR_6', 'Invalid timecode');
define('ENC_ERR_7', 'Invalid payload');
define('ENC_ERR_8', 'Runtime error');
	
define('X1', 31); // 19 + 12
define('X2', 26); // 19 + 7
define('X3', 27); // 19 + 8
define('X4', 24); // 19 + 5
define('X5', 22); // 19 + 3
define('Y1', 18);
define('Y2', 7);
define('Y3', 12);
define('Y4', 10);
define('Y5', 8);
define('Y6', 3);

define('GOLAY_POLY', 0xAE3);
#endregion

class Encryption implements IEncryption
{
	private $timestampASCIITable = "ABCEFGHJKMNPQRSTUVWXYZ0123456789";
	
	#region public

	public function packCipherText(&$text, $key, $serial, $initial_timecode, $minutes, $low_battery, &$error_code)
	{
		if(!$this->isValidKeySeed($key))
		{
			$error_code = ENC_ERR_4;
			return false;
		}
		
		if(!$this->isValidTimecodeSeed($initial_timecode))
		{
			$error_code = ENC_ERR_6;
			return false;
		}
		
		$key_seed_mgr = $this->keySeedToArray($key);
		
		$lsfrC = $key_seed_mgr;
		$key_mgr = array(0xDE00, 0xCD39, 0x05D9, 0x11C8, 0xD044);
		$this->constituteKey($lsfrC, $key_mgr);
		
		$lsfrD = $key_seed_mgr;		
		$key_dev = array(0xB589, 0x732A, 0xF1CC, 0xA238, 0x439E);
		$this->constituteKey($lsfrD, $key_dev);
		
		$signature = 0x9C;
		$signature ^= ($lsfrD[0] ^ $lsfrD[1] ^ $lsfrD[2] ^ $lsfrC[0] ^ $lsfrC[1] ^ $lsfrC[2]);
		
		$initial_timecode ^= 0x397338;
		$initial_timecode ^= ($lsfrC[0] ^ ($lsfrC[1] << 8) ^ ($lsfrC[2] << 16));
		$initial_timecode ^= ($lsfrD[0] ^ ($lsfrD[1] << 8) ^ ($lsfrD[2] << 16));
		
		$timecode = $initial_timecode + $minutes;
		
		$timestamp = array();
		$this->timestampGenerate($timestamp, $timecode, $serial, $signature, $low_battery);
		$this->timestampEncode($timestamp, $key_dev, 1);
		$this->timestampEncode($timestamp, $key_mgr, 0);
		$this->timestampEncodeAscii($timestamp, $text);
		
		return true;
	}

	public function unpackCipherText($text, $key, &$payload, &$error_code)
	{
		if(!$this->isValidCipherText($text))
		{
			$error_code = ENC_ERR_3;
			return false;
		}

		if(!$this->isValidKeySeed($key))
		{
			$error_code = ENC_ERR_4;
			return false;
		}
		
		$key_seed_mgr = $this->keySeedToArray($key);
		
		$lsfrC = $key_seed_mgr;
		$key_mgr = array(0xDE00, 0xCD39, 0x05D9, 0x11C8, 0xD044);
		$this->constituteKey($lsfrC, $key_mgr);
		
		$timestamp = array();
		$this->timestampDecodeAscii($timestamp, $text);
		$this->timestampDecode($timestamp, $key_mgr, 0);
		
		$lsfrD = $key_seed_mgr;		
		$key_dev = array(0xB589, 0x732A, 0xF1CC, 0xA238, 0x439E);
		$this->constituteKey($lsfrD, $key_dev);
		
		$signature = 0x9C;
		$signature ^= ($lsfrD[0] ^ $lsfrD[1] ^ $lsfrD[2] ^ $lsfrC[0] ^ $lsfrC[1] ^ $lsfrC[2]);
		
		$this->timestampDecode($timestamp, $key_dev, 1);
		if(!$this->timestampExtract($timestamp, $timecode, $serial, $low_battery, $signature, $error_code))
			return false;
		
		$payload = new Payload($serial, $timecode, $low_battery, $lsfrC, $lsfrD);
		
		return true;
	}
	
	// $range : multiples of 1m to look on either side of expected time.
	public function checkBadCipherText($bad_text, $expected_serial, $expected_timestamp, $key, $initial_timecode, $initial_timestamp, $low_battery, $range, &$report, &$error_code)
	{
		// Allow invalid chars but not bad length.
		if(strlen($bad_text) != 8)
		{
			$error_code = ENC_ERR_3;
			return false;
		}
		
		if(!$this->isValidKeySeed($key))
		{
			$error_code = ENC_ERR_4;
			return false;
		}
		
		if(!$this->isValidDeviceID($expected_serial))
		{
			$error_code = ENC_ERR_5;
			return false;
		}

		if(!$this->isValidTimecodeSeed($initial_timecode))
		{
			$error_code = ENC_ERR_6;
			return false;
		}
		
		// ****************** constitute **********************

		$key_seed_mgr = $this->keySeedToArray($key);
		
		$lsfrC = $key_seed_mgr;
		$key_mgr = array(0xDE00, 0xCD39, 0x05D9, 0x11C8, 0xD044);
		$this->constituteKey($lsfrC, $key_mgr);
		
		$lsfrD = $key_seed_mgr;		
		$key_dev = array(0xB589, 0x732A, 0xF1CC, 0xA238, 0x439E);
		$this->constituteKey($lsfrD, $key_dev);
		
		$signature = 0x9C;
		$signature ^= ($lsfrD[0] ^ $lsfrD[1] ^ $lsfrD[2] ^ $lsfrC[0] ^ $lsfrC[1] ^ $lsfrC[2]);

		$initial_timecode ^= 0x397338;
		$initial_timecode ^= ($lsfrC[0] ^ ($lsfrC[1] << 8) ^ ($lsfrC[2] << 16));
		$initial_timecode ^= ($lsfrD[0] ^ ($lsfrD[1] << 8) ^ ($lsfrD[2] << 16));
		
		// ************************************************************
		
		$expected_interval_sec = $expected_timestamp - $initial_timestamp;
		$expected_interval = (int)($expected_interval_sec / 60);
		$expected_timecode = $initial_timecode + $expected_interval;
		
		$report = array();
		
		for($i = $range; $i > 0 ; $i--)
		{
			$t = ($expected_timecode - $i);
			if($t < 0)
				$t += 0x3FFFFF;
				
			if($this->doPack($expected_text, $key_mgr, $key_dev, $expected_serial, $t, $signature, $low_battery))
			{
				$correct = $this->compareCipherTexts3($bad_text, $expected_text);
				$timestamp = $expected_timestamp - $i * 60;
				$report[] = array("correct" => $correct, "timestamp" => $timestamp, "expected_text" => $expected_text);
			}
			else
				return false;
		}

		if($this->doPack($expected_text, $key_mgr, $key_dev, $expected_serial, $expected_timecode, $signature, $low_battery))
		{
			$correct = $this->compareCipherTexts3($bad_text, $expected_text);
			$timestamp = $expected_timestamp;
			$report[] = array("correct" => $correct, "timestamp" => $timestamp, "expected_text" => $expected_text);
		}
		else
			return false;

		for($i = 1; $i <= $range; $i++)
		{
			$t = ($expected_timecode + $i);
			$t &= 0x3FFFFF;
			if($this->doPack($expected_text, $key_mgr, $key_dev, $expected_serial, $t, $signature, $low_battery))
			{
				$correct = $this->compareCipherTexts3($bad_text, $expected_text);
				$timestamp = $expected_timestamp + $i * 60;
				$report[] = array("correct" => $correct, "timestamp" => $timestamp, "expected_text" => $expected_text);
			}
			else
				return false;
		}

		return true;
	}

	public function getDevRegistrationStr(&$response, $key, $device_id, $initial_timecode, &$error_code)
	{
		return $this->getDevRegistrationStr2($response, $key, $key, $device_id, $initial_timecode, $error_code);
	}

	public function getDevRegistrationStr2(&$response, $key_seed_mgr, $key_seed_dev, $device_id, $initial_timecode_seed, &$error_code)
	{
		$key_seed_mgr = $this->keySeedToArray($key_seed_mgr);
		$key_seed_dev = $this->keySeedToArray($key_seed_dev);

		$response  = "010101010101010101010101";
		$response .= "010001001010110100101101";

		$buffer = ($key_seed_mgr[0] << 16) + ($key_seed_mgr[1] << 8) + $key_seed_mgr[2];
		//
		$g1 = $this->golayEncode($buffer >> 12);
		$g2 = $this->golayEncode($buffer & 0xffff);
		//
		for($mask = 0x800000; $mask; $mask >>= 1)
			$response .= ($g1 & $mask)? "1": "0";
		for($mask = 0x800000; $mask; $mask >>= 1)
			$response .= ($g2 & $mask)? "1": "0";
		
		$buffer = ($key_seed_dev[0] << 16) + ($key_seed_dev[1] << 8) + $key_seed_dev[2];
		//
		$g1 = $this->golayEncode($buffer >> 12);
		$g2 = $this->golayEncode($buffer & 0xffff);
		//
		for($mask = 0x800000; $mask; $mask >>= 1)
			$response .= ($g1 & $mask)? "1": "0";
		for($mask = 0x800000; $mask; $mask >>= 1)
			$response .= ($g2 & $mask)? "1": "0";
		
		$buffer = (($device_id & 0xff) << 16) + ($device_id & 0xff00) + (($device_id & 0x10000) >> 16) + ($initial_timecode_seed << 1);
		//
		$g1 = $this->golayEncode($buffer >> 12);
		$g2 = $this->golayEncode($buffer & 0xffff);
		//
		for($mask = 0x800000; $mask; $mask >>= 1)
			$response .= ($g1 & $mask)? "1": "0";
		for($mask = 0x800000; $mask; $mask >>= 1)
			$response .= ($g2 & $mask)? "1": "0";
			
		return true;
	}
	
	// Actually creates a key seed but routine keeps old name
	public function createRandomKey()
	{
		return $this->createRandomKeySeed();
	}

	public function createRandomKeySeed()
	{
		$chars = "0123456789ABCDEF";
		
		$key = '';
		for($i = 0; $i < 6; $i++)
			$key .= $chars[mt_rand(0, 15)];

		return $key;
	}

	public function createRandomKeySeed2()
	{
		//return sprintf("%06x", mt_rand(0, pow(2, 24)));
		return array(mt_rand(0, pow(2, 8) - 1), mt_rand(0, pow(2, 8) - 1), mt_rand(0, pow(2, 8) - 1));
	}

	// Actually creates a timecode seed but routine keeps old name
	public function createRandomTimecode()
	{
		return $this->createRandomTimecodeSeed();
	}

	public function createRandomTimecodeSeed()
	{
		return mt_rand(0, pow(2, 7) -1);
	}

	#endregion
	
	#region private
	#region validation
	private function isValidKey($key)
	{
		if(strlen($key) != 20)
			return false;

		$chars = "0123456789ABCDEF";
		for($i = 0; $i < 20; $i++)
		{
			if(strpos($chars, $key[$i]) === false)
				return false;
		}
		
		return true;
	}
	
	private function isValidKeySeed($key)
	{
		if(strlen($key) != 6)
			return false;

		$chars = "0123456789ABCDEF";
		for($i = 0; $i < 6; $i++)
		{
			if(strpos($chars, $key[$i]) === false)
				return false;
		}
		
		return true;
	}
	
	private function isValidDeviceID($devID)
	{
		return (($devID >=0) && ($devID < pow(2, 15)));
	}
	
	private function isValidTimecode($timecode)
	{
		return (($timecode >=0) && ($timecode < pow(2, 22)));
	}

	private function isValidTimecodeSeed($timecode)
	{
		return (($timecode >=0) && ($timecode < (pow(2, 7) -1)));
	}

	private function isValidCipherText($text)
	{
		if(strlen($text) != 8)
			return false;
			
		for($i = 0; $i < 8; $i++)
		{
			if(strpos($this->timestampASCIITable, $text[$i]) === false)
				return false;
		}
		
		return true;
	}

	#endregion
	#region Golay
	private function golayEncode($data)
	{
		$data = $this->golayMake($data);
		return ($data | ($this->golayParity($data) << 23));
	}

	private function golayMake($data)
	{
		$data = $data & 0xfff;
		$code = $data;
		
		for($i = 0; $i < 12; ++$i)
		{
			if($code & 1)
				$code ^= GOLAY_POLY; // 0xAE3
			$code >>= 1;
		}
		
		return (($code << 12) | $data);
	}

	private function golayParity($data)
	{
		$parity = $data & 0xFF;
		$parity ^= ($data >> 8) & 0xFF;
		$parity ^= ($data >> 16) & 0xFF;
		$parity ^= ($parity >> 4);
		$parity ^= ($parity >> 2);
		$parity ^= ($parity >> 1);
		return ($parity & 1) ^ 1;
	}

	#endregion
	#region misc
	// Expand seed into key
	private function constituteKey(&$lsfr, &$key)
	{
		for($i = 0; $i < 5; ++$i)
		{
			$lsfr[0] = $this->LFSRNext($lsfr[0]);
			$lsfr[1] = $this->LFSRNext($lsfr[1]);
			$lsfr[2] = $this->LFSRNext($lsfr[2]);
			$key[$i] ^= ($lsfr[0] ^ ($lsfr[1] << 4) ^ ($lsfr[2] << 8));
		}
	}

	private function not($n)
	{
		$not = '';
		$bin = decbin($n);
		$len = strlen($bin);
		for($i = 0; $i < 32 - $len; $i++)
			$not .= '1';
		for($i = 0; $i < $len; $i++)
		{
			if($bin[$i] == 0) $not .= '1';
			else $not .= '0';
		}

		return bindec($not);
	}

	private function myXOR($bin, $bit)
	{
		if($bin == '1' && $bit == 1)
			return '0';
		else if($bin == '1' || $bit == 1)
			return '1';
		else
			return '0';
	}

	private function shiftL($bin, $shift)
	{
		$bin = substr($bin, $shift);
		$bin = str_pad($bin, 32, "0", STR_PAD_RIGHT);
		return $bin;
	}
	
	private function shiftR($bin, $shift)
	{
		$bin = substr($bin, 0, 32 - $shift);
		$bin = str_pad($bin, 32, "0", STR_PAD_LEFT);
		return bindec($bin);		
	}

	private function keyToArray($key)
	{
		$k = str_split($key, 4);
		foreach($k as $i => $s)
		{
			$k[$i] = ("0x" . $s) + 0x00;
		}
		return $k;		
	}
	
	private function keyToStr($key_array)
	{
		$s = '';
		
		for($i = 0; $i < 5; ++$i)
		{
			$s .= sprintf("%04x", $key_array[$i]);
		}

		return $s;
	}
	
	private function keySeedToArray($seed)
	{
		$k = str_split($seed, 2);
		foreach($k as $i => $s)
		{
			$k[$i] = ("0x" . $s) + 0x00;
		}
		return $k;		
	}	
	
	private function LFSRNext($lfsr)
	{
		return (($lfsr << 1) | (((($lfsr >> 7) ^ (($lfsr >> 2) ^ ($lfsr >> 4) ^ ($lfsr >> 6))) & 1) << 0)) & 0xFF;
	}

	private function LFSRLast($lfsr)
	{
		return (($lfsr >> 1) | (((($lfsr >> 0) ^ (($lfsr >> 3) ^ ($lfsr >> 5) ^ ($lfsr >> 7))) & 1) << 7)) & 0xFF;	
	}

	private function LFSR8Next($lfsr)
	{
		return ((_lfsr << 1) | ((((_lfsr >> 7) ^ ((_lfsr >> 2) ^ (_lfsr >> 4) ^ (_lfsr >> 6))) & 1) << 0)) & 0xFF;
	}

	private function CRC8Write($crc, $data)
	{
		$Polynomial = 0x25;
		$crc = $crc ^ $data;
		for($bit = 8; $bit > 0; --$bit)
		{
			$crc = (($crc & 0x1) * $Polynomial) ^ ($crc >> 1);
		}
		return $crc;
	}
	
	#endregion
	#region unpack
	
	private function doPack(&$text, $key_mgr, $key_dev, $serial, $timecode, $signature, $low_battery)
	{
		$timestamp = array();
		$this->timestampGenerate($timestamp, $timecode, $serial, $signature, $low_battery);
		$this->timestampEncode($timestamp, $key_dev, 1);
		$this->timestampEncode($timestamp, $key_mgr, 0);
		$this->timestampEncodeAscii($timestamp, $text);
		
		return true;
	}
	
	private function timestampGenerate(&$timestamp, $timecode, $serial, $signature, $low_battery)
	{	
		// Limits.
		$timecode	&= (pow(2, 22) - 1);
		$serial		&= (pow(2, 17) - 1);

		/*CTTT TTTT TTTT TTTT TTTT TTTS SSSS SSSS SSSS SSSS*/
		$timestamp[0] = ($serial & 0xFF);
		$timestamp[1] = (($serial >> 8) & 0xFF);
		$timestamp[2] = ((($serial >> 16) & 0xFF) | (($timecode << 1) & 0xFF));
		$timestamp[3] = (($timecode >> 7) & 0xFF);
		$timestamp[4] = ((($timecode >> 15) | ($signature << 7)) & 0xFF);
		
		$timestamp[4] ^= (($low_battery << 7) & 0xFF);
	}
	
	private function timestampExtract(&$timestamp, &$timecode, &$serial, &$low_battery, $signature, &$error_code)
	{
		$serial = ($timestamp[0] | ($timestamp[1] << 8) | (($timestamp[2] & 0x01) << 16)) & (pow(2, 17) - 1);
		$timecode = (
					($timestamp[2] >> 1) |
					($timestamp[3] << 7) |
					($timestamp[4] << 15)
					) & (pow(2, 22) - 1);
		$low_battery = (($timestamp[4] >> 7) ^ $signature) & 0x01;

		return true;
	}
	
	private function timestampEncode(&$timestamp, $key, $stage)
	{
		$text = '';

		for($i = 0; $i < 4; ++$i)
		{
			$text .= sprintf("%08b", $timestamp[$stage + $i]);
		}

		if(!$this->encrypt($key, $text, $cipher_text, $error_code))
		{
			echo 'Error: ' . $error_code . '<br>';
		}
		
		$text = $cipher_text;

		for($i = 0; $i < 4; ++$i)
		{
			$timestamp[$stage + $i] = bindec(substr($text, 24 - 8 * $i, 8));
		}
	}

	private function timestampDecode(&$timestamp, $key, $stage)
	{
		$text = '';

		for($i = 4; $i-- > 0; )
		{
			$text .= sprintf("%08b", $timestamp[$stage + $i]);
		}

		$text = $this->decrypt($key, $text, $error_code);

		for($i = 0; $i < 4; ++$i)
		{
			$timestamp[$stage + $i] = bindec(substr($text, 24 - 8 * (3 - $i), 8));
		}
	}

	private function encrypt($key, $plain_text, &$cipher_text, &$error_code)
	{
		$data = $plain_text;
		$lfsr = 0xFF;

		for($i = 0; $i < 254; ++$i)
		{	
			$lfsr = $this->LFSRNext($lfsr);
			$not = $this->not($lfsr);

			$shift = ($lfsr >> 4) & 0x0F;
			$ka = (($not >> 3) & ($not >> 2) & ($key[0] >> $shift)) ^ ((($lfsr >> 3) | ($lfsr >> 2)) & ($key[($lfsr & 0x03) + 1] >> $shift));
			$kb = (($not >> 3) & ($lfsr >> 2) & ($key[4] >> $shift)) ^ ((($lfsr >> 3) | ($not >> 2)) & ($key[($not & 0x03) + 0] >> $shift));
			$ir = ($lfsr >> 7);

			$mb = $data[0] + 0;
			$fa = $ka ^ $this->shiftR($data, X2) ^ ($this->shiftR($data, X3) & $this->shiftR($data, X4)) ^ ($this->shiftR($data, X5) & ($ir));
			$fb = $kb ^ $this->shiftR($data, Y2) ^ ($this->shiftR($data, Y3) & $this->shiftR($data, Y4)) ^ ($this->shiftR($data, Y5) & $this->shiftR($data, Y6));

			$data = $this->shiftL($data, 1);
			$data[31] = $this->myXOR($data[31], 0x01 & ($fa ^ $mb));
			$data[31 - 19] = $this->myXOR($data[31 - 19], 0x01 & $fb);
		}
		$cipher_text = $data;
		
		return true;
	}
	
	private function decrypt($key, $cipher_text, &$error_code)
	{
		$data = $cipher_text;
		$lfsr = 0xFF;

		for($i = 0; $i < 254; ++$i)
		{	
			$lfsr = $this->LFSRLast($lfsr);
			$not = $this->not($lfsr);

			$shift = ($lfsr >> 4) & 0x0F;
			$ka = (($not >> 3) & ($not >> 2) & ($key[0] >> $shift)) ^ ((($lfsr >> 3) | ( $lfsr >> 2)) & ($key[( $lfsr & 0x03) + 1] >> $shift));
			$kb = (($not >> 3) & ( $lfsr >> 2) & ($key[4] >> $shift)) ^ ((($lfsr >> 3) | ($not >> 2)) & ($key[($not & 0x03) + 0] >> $shift));
			$ir = ($lfsr >> 7);	

			$lb = $data[31] + 0;
			$data = substr($data, 0, 31);
			$data = str_pad($data, 32, "0", STR_PAD_LEFT);
			$fa = $ka ^ $this->shiftR($data, X2) ^ ($this->shiftR($data, X3) & $this->shiftR($data, X4)) ^ ($this->shiftR($data, X5) & ($ir));
			$fb = $kb ^ $this->shiftR($data, Y2) ^ ($this->shiftR($data, Y3) & $this->shiftR($data, Y4)) ^ ($this->shiftR($data, Y5) & $this->shiftR($data, Y6));

			$data[0] = $this->myXOR($data[0], 0x01 & ($fa ^ $lb));
			$data[31 - 18] = $this->myXOR($data[31 - 18], 0x01 & $fb);
		}

		return $data;
	}
	
	private function timestampEncodeAscii($timestamp, &$text)
	{
		$text = '00000000';
		
		for($i = 0; $i < 8; ++$i)
		{
			$v = 0;
			for($j = 0; $j < 5; ++$j)
			{
				$v = (($v << 1) | (($timestamp[$j] >> $i) & 1));
			}
			$text[$i] = $this->timestampASCIITable[$v];
		}
	}
	
	private function timestampDecodeAscii(&$timestamp, $text)
	{
		for($j = 0; $j < 5; ++$j)
		{
			$timestamp[$j] = 0;
		}
		for($i = 0; $i < 8; ++$i)
		{
			$found = false;
			for($v = 0; $v < 32; ++$v)
			{
				if($text[$i] == $this->timestampASCIITable[$v])
				{
					for($j = 5; $j-- > 0; )
					{
						$timestamp[$j] |= ((1 << $i) * ($v & 1));
						$v >>= 1;
					}
					$found = true;
					break;
				}
			}
			if(!$found)
			{
				return false;
			}
		}
		return true;
	}

	#region misc

	private function compareCipherTexts($bad_text, $candidate_text)
	{
		$s = '';
		$wrong = 0;
		for($i = 0; $i < 8; $i++)
		{
			if($bad_text[$i] == $candidate_text[$i])
			{
				$s .= $candidate_text[$i];
			}
			else
			{
				$s .= '<span style="color:red;">' . $candidate_text[$i] . '</span>';
				$wrong++;
			}
		}
		
		return $s;
	}
	
	private function compareCipherTexts2($bad_text, $candidate_text)
	{
		$s = '';
		$wrong = 0;
		for($i = 0; $i < 8; $i++)
		{
			if($bad_text[$i] == $candidate_text[$i])
			{
				$s .= $candidate_text[$i];
			}
			else
			{
				$s .= '<span style="color:red;">' . $candidate_text[$i] . '</span>';
				$wrong++;
			}
		}
		
		$a = array("text" => $s, "wrong" => $wrong);
		
		return $a;
	}	
	
	private function compareCipherTexts3($bad_text, $candidate_text)
	{
		$correct = 8;
		for($i = 0; $i < 8; $i++)
		{
			if($bad_text[$i] != $candidate_text[$i])
				$correct--;
		}
		
		return $correct;
	}	
	
	#endregion

}

?>
