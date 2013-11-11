<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

<title>Code Summary</title>

<style type="text/css">

* { font-family:Arial, Helvetica, sans-serif; font-size:14px; }
body {
	background-image:url('<?php echo site_url(); ?>images/summary-sheet-bg.png'); 
	background-repeat: repeat; 
	background-position:top;
	width: 100px;
	height: 100px;
	font-size:13px;
}

#footer { position:fixed; left:0; right:0; bottom:20px; border-top:0.1pt solid #aaa; color:#333; font-size:0.9em; padding-top:20px; }

table { border-collapse:collapse; width:100%; }
a { color:#ED1C24; text-decoration:none; }

#header { margin-bottom:30px; font-size:12px;}

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
.header td { font-size: 12px; }
#createdby { margin: 20px 0px 5px 9px; font-size: 11px; border-top: 1px solid #cdcdcd; padding: 5px 0px 0px 0px;}
</style>
<meta name="dompdf.view" content="FitH" />
</head>
<body>

<table id="header">
<tr>
<td><img src="<?=$root?>images/logo-medium.png" width="200" /></td>
<td align="right" style="font-size: 12px;">
Date: <?=date("j F Y H:i")?><br />
User: <?=$this->user->name?><br />
Company: <?=$this->account->company_name?><br />
Account Number: <?=$this->account->account_number?><br />
Unique Ref: <?=$rand_number?>
</td>
</table>

<h4>Codes Summary</h4>
<?php if ($codes) { ?>
	<table class="codes">
		<thead>
			<tr>
				<th>Batch/Ref No</th>
				<th>Start Code</th>
				<th>End Code</th>
				<th>Added</th>
			</tr>
		</thead>
		<?php foreach ($codes as $code) { ?>
		<tbody>
			<tr>
				<td><?php if (empty($code['batch_ref'])) { echo 'N/A'; } else { echo $code['batch_ref']; } ?></td>
				<td><?php if (empty($code['code'])) { echo 'N/A'; } else{ echo $code['code']; } ?></td>
				<td><?php if (empty($code['end_code'])) { echo 'N/A'; } else { echo $code['end_code']; } ?></td>
				<td><?php if (empty($code['added_at'])) { echo 'N/A'; } else { echo $code['added_at']; } ?></td>
			</tr>
		</tbody>
		<?php } ?>
	</table>
<?php } ?>
<div id="createdby">
Report created by: <?php echo $this->session->userdata('first_name'); ?>
</div>
</body>
</html>