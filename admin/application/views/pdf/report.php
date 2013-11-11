<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
<title>Report</title>

<style type="text/css">

body {
	/* background-image:url('images/summary-sheet-bg.png'); background-repeat: no-repeat; background-position:top center; */
	width: 330px;
	height: 227px;
	font-family: 'Open Sans', sans-serif;
	font-size: 12px;
}
/*
#container {
	margin: 0 auto;
	max-height: 100%;
	max-width: 330px;
	width: 330px;
	height: 227px;
}
*/
#header {
	margin-bottom:30px;
}
#content {
	margin-bottom:30px;
}
#content td { padding:2px; border-bottom:solid 1px #CCC; }
#content tfoot td { font-weight:bold; border-bottom:none; }
#content thead { display: none; visibility:collapse;}
#content thead th { display: none; visibility:collapse;}
#content thead tr { display: none; visibility:collapse;}
#content table input {display: none; visibility:collapse;}
#content table select {display: none; visibility:collapse;}
#footer {
	position:fixed; left:0; right:0; bottom:20px; border-top:0.1pt solid #aaa; color:#333; font-size:0.9em; padding-top:20px;
}
table { border-collapse:collapse; width:100%; }
a { color:#ED1C24; text-decoration:none; }
.page-number:before { content: "Page" counter(page); }
</style>
</head>
<body>

	
		<table id="header">
			<tr>
				<td align="left" width="40%"><img src="<?=$root?>images/logo-medium.png" width="250" /></td>
				<td align="right" width="45%">
					Generated: <?=date("j F Y - H:i")?><br />
					User: <?=$this->user->name?><br />
					Company: <?=$this->account->company_name?><br />
					Account Number: <?=$this->account->account_number?>
				</td>
		</table>

		<table id="content" name="tbl">
			<?=$html?>
		</table>

	<!--
		<table id="footer">
			<tr>
				<td width="30%" align="left">These times have been verified by Clock In Point</td>
				<td width="15%" align="center"><div class="page-number"></div></td>
				<td width="15%" align="right"><a href="http://www.clockinpoint.com">www.clockinpoint.com</a></td>
			</tr>
		</table>
	-->

	
</body>
</html>