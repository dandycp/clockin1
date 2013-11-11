<div class="summary">

<script src="<?php echo site_url(); ?>js/reports.js"></script>
<script src="<?php echo site_url(); ?>js/timepicker.js"></script>
<script>
$(function() {
	$("#ref-form").hide();
	$("#enter-ref").click(function(e) { e.preventDefault(); $("#ref-form").toggle(); });

	$('#offset').datetimepicker({controlType: 'select'});
	
});
</script>
<?php
//var_dump($result);
//var_dump($this->session->userdata('result'));
?>

<div class="alert alert-warning">
	<strong>Thank you</strong><br />
	Does the time &amp; date shown below match your records?<br /><br />
	<a class="btn btn-success btn-large" href="<?php echo site_url(); ?>clients/devices/records_matched" data-toggle="tooltip" data-title="Continue" data-placement="left">Yes</a> 
	<a id="enter-ref" href="#" class="btn btn-danger btn-large" data-toggle="tooltip" data-title="Click to enter your own" data-placement="right">No</a>
	
	<div style="margin:10px 0px 0px 0px;">
		<form id="ref-form" class="form-inline" method="post" action="<?php echo site_url(); ?>clients/devices/update_offset/<?php echo $this->uri->segment(4); ?>">
				<div class="row">
				  <div class="col-lg-1">
				    <label for="inputEmail1" class="control-label">Your date/time</label>
				  </div>
				  <div class="col-lg-2">
				    <input name="new_date" type="text" class="form-control" id="offset" value=""/>
				  </div>
				  <div class="col-lg-2">
					<button type="submit" class="btn btn-success">Continue &raquo;</button>
				  </div>
				  
				</div>
		</form>
	</div>
</div>

<table class="table table-condensed">
	<thead>
		<tr>
			<th>Time/Date</th>
			<th>Code</th>
			<th>Device</th>
			<th>Location</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo $result['reason']; ?></td>
			<td><?php echo $code; ?></td>
			<td><?php echo $get_device->name; ?></td>
			<td><?php echo $get_device->location; ?></td>
		</tr>
	</tbody>
</table>