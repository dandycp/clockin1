<?php
// v2.0
error_reporting(-1);
ini_set("display_errors", 1);

// Include Libraries
include_once APPPATH.'encryption.php';
include_once APPPATH.'payload.php';

// Set Timezone
date_default_timezone_set('Europe/London');
// Following call ensures date_default_timezone_set() has been called, if previous line is not used
// date_default_timezone_set(date_default_timezone_get());

$format = 'Y-m-d H:i:s P';

if(isset($_POST["id"]))
{
	$id = $_POST["id"];
	echo 'Registered Device ID: ' . $id . '<br>';
}
if(isset($_POST["time"]))
{
	$time = $_POST["time"];
	echo 'Registration Date: ' . $time . '<br>';
}	
$text = $_POST["text"];
$key = $_POST["key"];
$t0 = $_POST["t0"];
$d0 = $_POST["d0"];

$text = strtoupper($text);
$key = strtoupper($key);

$enc = new Encryption();
$timestamp = array();

// In practice, get manager key from DB.
if($enc->unpackCipherText($text, $key, $payload, $error_code))
{
	$serial = $payload->getDeviceId();
	// In practice, use Device ID to get t0 and d0 from DB
	$date = $payload->getDateTime($t0, $d0);
	$low_battery = $payload->getLowBattery();

	echo 'Text: ' . $text . '<br><br>';
	
	echo 'Decrypted values:<br>';
	echo '- Device ID: ' . $serial . sprintf(" %x", $serial) . '<br>';
	echo '- Date: ' . $date->format($format) . '<br>';
	echo '- Low Battery: ' . $low_battery . '<br><br>';	
}
else
	echo 'Error: ' . $error_code . '<br>';

?>