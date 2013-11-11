<!DOCTYPE html>
<html>
<!-- v 2.0 -->
<head>
<style>
input
{
  width: 200px;
}
</style>
</head>
<body>
<form method="post" action="unpack.php">

<?php
error_reporting(-1);
ini_set("display_errors", 1);

$lines = file('t6.log', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$count = count($lines);

$key = getValue($lines[$count - 5]);
$id = getValue($lines[$count - 4]);
$t0 = getValue($lines[$count - 3]);
$d0 = getValue($lines[$count - 2]);
$time = getTime($lines[$count - 2]);

echo "Registered Device ID: $id<br>";
echo "Registration Date: $time<br><br>";
echo "<input type=\"text\" name=\"text\" value=\"\"> Text<br><br>";
echo "<input type=\"text\" name=\"key\" value=\"$key\"> Key (seed)<br><br>";
echo "<input type=\"text\" name=\"t0\" value=\"$t0\"> Initial Timecode (seed)<br><br>";
echo "<input type=\"text\" name=\"d0\" value=\"$d0\"> Initial Timestamp<br><br>";

echo "<input type=\"hidden\" name=\"time\" value=\"$time\">";
echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";

function getValue($line)
{
	$a = explode(": ", $line);
	$s = $a[1];
	
	return $s;
}

function getTime($line)
{
	$a = explode(" time", $line);
	$s = $a[0];
	$s = substr($s, 2, 17);
	
	return $s;
}

?>
<input type="submit" value="Submit">
<p>All fields are required</p>
</form>
</body>
</html>