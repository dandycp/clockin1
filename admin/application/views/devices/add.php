<h1>Add device</h1>
<h2>Step 1</h2>
<p>Some instructional text will go here about how the user needs to register the device before using it. It will also mention this is a quick 2 step process.</p>
<? if ($error) : ?>
<div class="alert alert-danger"><strong>Error: </strong><?=$error?></div>
<? endif ?>
<form class="form-horizontal" action="" method="post">
	
	<div class="form-group">
		<div class="col-lg-4">
		<label>Device Name</label>
			<input type="text" name="name" value="<?=$device->name?>" class="form-control"/>
			<span class="help-block">Give your device a name. This will be used to identify the device in future reporting.</span>
		</div>
	</div>
	
	<legend><span>About the location the device will be installed at</span></legend>
	
	<?=$this->load->view('common/address', compact('address', 'countries'))?>
	
	<div class="form-group">
		<div class="col-lg-4">
		<label>Device Location</label>
		
			<textarea name="location" rows="3"><?=$device->location?></textarea>
			<p><small>eg: "<em>Inside of house, on the right of the front door.</em>"</small></p>
		</div>
	</div>
	<div class="form-group">
	    <div class="col-lg-3">
	    	<label>Tolerance Rate</label>
	      <input type="text" class="form-control" value="<?php echo $client->tolerance_rate; ?>" name="tolerance_rate">
	    </div>
    </div>
	</fieldset>
	<div class="form-group">
		<div class="col-lg-1">
			<button type="submit" class="btn btn-success">Submit</button>
		</div>
	</div>
</form>
