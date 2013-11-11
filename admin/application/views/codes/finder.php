<h1>Near Miss Finder</h1>
<? if ($error) : ?>
<div class="alert alert-danger"><strong>Error: </strong>
	<?=$error?>
</div>
<? endif ?>
<form class="form-horizontal" action="" method="post">
	
		<div class="form-group">
			<div class="col-lg-4">
			<label class="control-label">Device:</label>
			<div class="controls">
				<select name="device_id" class="form-control">
				<? foreach ($devices as $device) : ?>
				<option value="<?=$device->id?>" <? if ($device_id == $device->id) echo 'selected'?>><?=$device->name?></option>
				<? endforeach ?>
				</select>
			</div>
			</div>
		</div>

	
		<div class="form-group">
			<div class="col-lg-4">
			<label class="control-label">Code:</label>
			<div class="controls">
				<input type="text" name="code" value="<?=$code?>" class="form-control">
			</div>
			</div>
		</div>
		
	
		<div class="form-group">
			<div class="col-lg-4">
			<label class="control-label">Expected Date:</label>
			<div class="controls">
				<input type="text" id="date" name="date" value="<?=$date?>" class="form-control"> <span class="help-inline">(YYYY-MM-DD)</span>
			</div>
			</div>
		</div>
	
	
		<div class="form-group">
			<div class="col-lg-4">
			<label class="control-label">Expected Time:</label>
			<div class="controls">
				<input type="time" id="time" name="time" value="<?=$time?>" class="form-control"> <span class="help-inline">(HH:MM)</span>
			</div>
			
			</div>
		</div>
		
	<div class="form-actions">
		<button type="submit" class="btn btn-success btn-large">Get Results</button>
	</div>
	
	
</form>

<script>
$(function() {
	
	$("#date").datepicker({ 
		defaultDate:"-1M",
		dateFormat: "yy-mm-dd",
		maxDate:"+0D",  
		onClose: function( selectedDate ) {
			$("#time").focus();
		} 
	});
	
});
</script>

<? if (!empty($data)) : ?>
<? if (!empty($results)) : ?>
<div class="alert alert-info">
The following possible codes/times were found:<br /><br />
<ul>
<? foreach ($results as $result) : ?>
<li><?=$result['code']?> - <?=$result['time']?> (<?=$result['matches']?> characters match)</li>
<? endforeach ?>
</ul>
</div>
<? else : ?>
<div class="alert alert-danger">
No results were found
</div>
<? endif ?>
<? endif ?>