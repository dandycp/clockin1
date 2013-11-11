<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

<title>Summary</title>

<style type="text/css">

* { font-family:Arial, Helvetica, sans-serif; font-size:14px; }
body {
	background-image:url('<?php echo site_url(); ?>images/summary-sheet-bg.png'); 
	background-repeat: repeat; 
	background-position:top;
	width: 100px;
	height: 100px;
	font-size:14px;
}

#footer { position:fixed; left:0; right:0; bottom:20px; border-top:0.1pt solid #aaa; color:#333; font-size:0.9em; padding-top:20px; }

table { border-collapse:collapse; width:100%; }
a { color:#ED1C24; text-decoration:none; }

#header { margin-bottom:30px; }

#codes { margin-bottom:30px; }
#codes th { width:auto !important; text-align:left; }
#codes th input, #codes th select { display:none; }
#codes td { padding:4px; border-bottom:solid 1px #CCC; }
#codes tfoot td { font-weight:bold; border-bottom:none; }

.page-number:before { content: "Page " counter(page); }

.codes {
	margin:0px;padding:0px;
	width:100%;
}.codes table{
	width:100%;
	height:100%;
	margin:0px;padding:0px;
}.codes tr:last-child td:last-child {
	-moz-border-radius-bottomright:0px;
	-webkit-border-bottom-right-radius:0px;
	border-bottom-right-radius:0px;
}
.codes table tr:first-child td:first-child {
	-moz-border-radius-topleft:0px;
	-webkit-border-top-left-radius:0px;
	border-top-left-radius:0px;
}
.codes table tr:first-child td:last-child {
	-moz-border-radius-topright:0px;
	-webkit-border-top-right-radius:0px;
	border-top-right-radius:0px;
}.codes tr:last-child td:first-child{
	-moz-border-radius-bottomleft:0px;
	-webkit-border-bottom-left-radius:0px;
	border-bottom-left-radius:0px;
}.codes tr:hover td{
	background-color:#ffffff;
}
.codes th{
	vertical-align:middle;
	border-bottom: 1px solid #cdcdcd;
	font-weight: bold;
	text-align:left;
	padding:14px;
	font-size:10px;
	font-family:Arial;
	font-weight:normal;
	color:#000000;
}
.codes td{
	vertical-align:middle;
	background-color:#ffffff;
	text-align:left;
	padding:14px;
	font-size:10px;
	font-family:Arial;
	font-weight:normal;
	color:#000000;
}.codes tr:last-child td{
	border-width:0px 1px 0px 0px;
}.codes tr td:last-child{
	border-width:0px 0px 1px 0px;
	border-bottom: 1px solid #cdcdcd;
}.codes tr:last-child td:last-child{
	border-width:0px 0px 0px 0px;
}
.codes tr:first-child td{
		background:-o-linear-gradient(bottom, #e5e5e5 5%, #e5e5e5 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #e5e5e5), color-stop(1, #e5e5e5) );
	background:-moz-linear-gradient( center top, #e5e5e5 5%, #e5e5e5 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#e5e5e5", endColorstr="#e5e5e5");	background: -o-linear-gradient(top,#e5e5e5,e5e5e5);
	background-color:#e5e5e5;
	text-align:center;
	font-size:14px;
	font-family:Arial;
	font-weight:bold;
	color:#000000;
}
.codes tr:first-child:hover td{
	background:-o-linear-gradient(bottom, #e5e5e5 5%, #e5e5e5 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #e5e5e5), color-stop(1, #e5e5e5) );
	background:-moz-linear-gradient( center top, #e5e5e5 5%, #e5e5e5 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#e5e5e5", endColorstr="#e5e5e5");	background: -o-linear-gradient(top,#e5e5e5,e5e5e5);

	background-color:#e5e5e5;
}
.header td { font-size: 14px; }

</style>
<meta name="dompdf.view" content="FitH" />
</head>
<body>

<table id="header">
<tr>
<td><img src="<?=$root?>images/logo-medium.png" width="200" /></td>
<td align="right" style="font-size: 14px;">
Date: <?=date("j F Y H:i")?><br />
User: <?=$this->user->name?><br />
Company: <?=$this->account->company_name?><br />
Account Number: <?=$this->account->account_number?><br />
Unique Ref: <?=$rand_number?>
</td>
</table>

<h4>Batch Summary <?=$batch_ref?></h4>

<? if ($codes) : ?>
<table class="codes">
<? foreach ($codes as $i => $code) : ?>
<tr>
	<th>Start Code</th>
	<th>End Code</th>
	<th>Time/Date</th>
	<th>Verified</th>
	<th>Device Name</th>
	<th>Address</th>
	<th>Location</th>
	<th>Duration</th>
</tr>
<tr>
<td> <?=$code->code?></td>
<td><? if (!empty($code->end_code)) : ?><?=$code->end_code?><? endif ?></td>
<td><?=date("H:i d/m/Y", strtotime($code->time))?><? if (!empty($code->end_code)) : ?><?=date("H:i d/m/Y", strtotime($code->end_time))?><? endif ?></td>
<td><img src="<?=$root?>images/tick.png" width="16" /></td>
<td><?=$code->device->name?></td>
<td><?=$code->device->address->full_address()?></td>
<td><?=$code->device->location?></td>
<td><? if (!empty($code->end_code)) : ?><?=timespan(0, $code->duration)?><? endif ?></td>
</tr>
<? endforeach ?>
<tfoot>
<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td><strong>Total Duration</strong></td>
<td><?=$total_duration?></td>
</tr>
</tfoot>
</table>

<? endif ?>

</body>
</html>