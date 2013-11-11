<h1>Delete Device</h1>

<p class="text-warning">Are you sure you want to permanently delete this device?</p>
<form class="form-horizontal" action="" method="post">
<input type="hidden" name="id" value="<?=$device->id?>" />
	<div class="control-group">
		<label class="control-label">Address:</label>
		<div class="controls">
			<textarea disabled="disabled"><?=$device->address->full_address()?></textarea>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label">Location:</label>
		<div class="controls">
			<input type="text" value="<?=$device->location?>" disabled="disabled" />
		</div>
	</div>
	
	<div class="form-actions">
		<button type="submit" class="btn btn-success btn-large">Delete</button>
	</div>
</form>