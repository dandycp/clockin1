<script src="<?php echo site_url(); ?>js/validate-code.js"></script>
<script type="text/javascript">
$(function() {   

    $("#c").click(function(){
      $("#a").show();
      $("codes").addClass(".success");
      $("#check-form").hide();
    });  

});
</script>
<script>
$(function() {
	$("#ref-form").hide();
	$("#enter-ref").click(function(e) { e.preventDefault(); $("#ref-form").toggle(); });

	$('#offset').datetimepicker({controlType: 'select'});
	
});
</script>
<div id="check-form">
<h3>Device Check</h3>

<p>Please enter a code from your device, this will be then checked against your records.</p>
<?php
	if ($result['valid'] == false) {
		echo '<div class="alert alert-danger">'.$result['reason'].'</div>';
	}
	else { echo ''; }
?>
<!--<?php echo site_url(); ?>clients/devices/check/<?php echo $this->uri->segment(4); ?>-->

<form class="form-inline" action="" method="post">

	<div class="form-group">
	
		<label>Enter Code: </label> <input type="text" maxlength="8" width="8" class="code single-code form-control" data-type="single_codes" name="singles[0][code]" id="codes" autofocus>
		
	</div>
	<div class="form-group">
		<button class="btn btn-success" id="submit">Check</button>
	</div>
	<br /><br />
	<?php 
	//var_dump($result);
	if ($result['valid'] == true) { ?>
		<div class="alert alert-success">That code matches your device, you can now <a href="#" id="c">continue &raquo;</a></div>
	<?php } ?>
</form>
</div>

<div id="a" style="display:none;">
<div class="well">
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
</div>

