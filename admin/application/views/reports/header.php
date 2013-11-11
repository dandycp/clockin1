<script src="js/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="js/datatables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="js/datatables/extras/ColVis/media/js/ColVis.min.js"></script>
<script src="js/reports.js"></script>
<script src="js/reports_new.js"></script>
<script src="js/timepicker.js"></script>
<link rel="stylesheet" href="js/datatables/extras/TableTools/media/css/TableTools.css" />
<link rel="stylesheet" href="js/datatables/extras/ColVis/media/css/ColVis.css" />

<!--
<div id="navbar-reports" class="navbar navbar-static">
  <div class="navbar-inner">
  	
	  <a class="brand" href="#">Reports: </a>
	  <ul class="nav" role="navigation">
	  
	  	<li <? if (uri_string()=='reports') echo 'class="active"'?>><a href="reports">Summary</a></li>
	  
	  	<? if ($this->account->has_devices()) : ?>
		<li <? if (uri_string()=='reports/times') echo 'class="active"'?>><a href="reports/times">Times</a></li>
		<li <? if (uri_string()=='reports/durations') echo 'class="active"'?>><a href="reports/durations">Durations</a></li>
		<? endif ?>
		
		<? if ($this->account->has_clients()) : ?>
		<li class="dropdown">
		  <a href="reports" id="drop2" role="button" class="dropdown-toggle" data-toggle="dropdown">Client Reporting <b class="caret"></b></a>
		  <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
			<li <? if (uri_string()=='reports') echo 'class="active"'?>><a href="reports">Home</a></li>
			<li <? if (uri_string()=='reports/client_times') echo 'class="active"'?>><a href="reports/client_times">Times</a></li>
			<li <? if (uri_string()=='reports/client_durations') echo 'class="active"'?>><a href="reports/client_durations">Durations</a></li>
		  </ul>
		</li>
		<? else : ?>
		<? endif ?>

		
	  </ul>
	 
  </div>
</div> 

-->
<div class="row">

<div class="span12">
<!--
	<form id="date-control" class="pull-left" action="reports/set_period" method="post">
		<input type="text" name="from" id="from" class="input-small" placeholder="Date From" value="<?php $this->report->get_from('M j, Y')?>" /> - 
		<input type="text" name="to" id="to" class="input-small" placeholder="Date To" value="<?php $this->report->get_to('M j, Y')?>" />
		<button type="submit" class="btn">Apply</button>
	</form>
-->

