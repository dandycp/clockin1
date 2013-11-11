<?php 

// makes a base64 string safe for using in urls
function base64_url_encode($input) {
	return strtr($input, '+/=', '-_:');
}

function base64_url_decode($input) {
	return strtr($input, '-_:', '+/=');
}

// returns a date time string suitable for storing as mysql datetime
function mysql_datetime($date = '') {
	$time = ($date == '') ? time() : strtotime($date) ;
	return date ("Y-m-d H:i:s", $time);
}

function datetime($date = '') {
	$time = ($date == '') ? time() : strtotime($date) ;
	return date('jS M Y H:i', $time);
}

function mydate($date = '') {
	$time = ($date == '') ? time() : strtotime($date) ;
	return date('j F Y', $time);
}

function shortdate($date = '') {
	$time = ($date == '') ? time() : strtotime($date) ;
	return date('j M Y', $time);
}

function short_mydate($date = '') {
	$time = ($date == '') ? time() : strtotime($date) ;
	return date('j<\s\u\p>S</\s\u\p> M Y', $time);
}

// generate 8 digit alphanumeric order ref
function generate_order_ref() {
	return strtoupper(dechex(time()));
}

// generate 10 digit numeric order ref
function generate_numeric_ref() {
	return time(); 
}

function format_bytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
  
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
  
    $bytes /= pow(1024, $pow);
  
    return round($bytes, $precision) . ' ' . $units[$pow];
} 

// returns a string suitable for use in a URL
function url_friendly($str) {
	return preg_replace("/[^a-zA-Z0-9\_\-]/", '', str_replace(' ','-',$str));
}

// converts most chars (including MS Word chars) to html suitable ones (useful for displaying stuff entered into CMS)
function encode_chars($str){
	$str = stripslashes($str);
	$str = strtr($str, get_html_translation_table(HTML_ENTITIES));
	$str = str_replace( 
		array("\x82", "\x84", "\x85", "\x91", "\x92", "\x93", "\x94", "\x95", "\x96",  "\x97"), 
		array("&#8218;", "&#8222;", "&#8230;", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8226;", "&#8211;", "&#8212;"),
		$str);
	return $str;
}

// double encode function for encoding filenames that will go through an .htaccess rewrite
function rw_encode($str) {
	return urlencode(urlencode($str));
}

// returns a string up to a number of chars including complete words - used by news snippets
function limit_text($string, $length, $replacer = '...') {
  if ($length >= strlen($string)) return $string;
  return (preg_match('/^(.*)[\s-].*$/s', substr($string, 0, $length+1), $matches) ? $matches[1] : trim(substr($string, 0, $length))) . $replacer;
}

// used for showing brief snippets of news items
function show_snippet($str, $limit=120) {
	// replace paras with line breaks
	$str = strip_tags($str);
	return limit_text($str, $limit);
}