<h3>Edit Provider Settings</h3>
<!--
<pre>
<code>
<?php var_dump($client); ?>
</code>
</pre>
-->

<?php if ($errors) { echo $errors; } ?>
<?php if ($this->session->flashdata('message')) { echo '<div class="alert alert-success">'.$this->session->flashdata('message').'</div>'; } ?>
<form action="" method="post" role="form" class="form-horizontal">
	
	<div class="form-group">
	    <div class="col-lg-3">
	    	<label>Expected Hours (per month)</label>
	      	<input type="text" class="form-control" value="<?php echo $client->hour_rate; ?>" name="hour_rate">
	    </div>
    </div>

	<div class="form-group">
	    <div class="col-lg-3">
	    	<label>Actual Hours (per month)</label>
	      	<input type="text" class="form-control" value="<?php echo $client->actual_hours; ?>" name="actual_hours">
	    </div>
    </div>

	<div class="form-group">
	    <div class="col-lg-3">
	    	<label>Incorrect Codes (per month) Tolerance Rate</label>
	      <input type="text" class="form-control" value="<?php echo $client->tolerance_rate; ?>" name="tolerance_rate">
	    </div>
    </div>
	

    <div class="form-group">
    	<div class="col-lg-2">
    		<input type="submit" class="btn btn-success" value="Save" name="submit">
    	</div>
    </div>

</form>