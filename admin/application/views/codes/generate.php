<h1>Generate Codes</h1>
<? if ($error) : ?>
<div class="alert alert-error"><strong>Error: </strong>
	<?=$error?>
</div>
<? endif ?>
<form class="form-horizontal" action="" method="post">
	
	<div class="row-container">
		<div class="control-group">
			<label class="control-label">Device:</label>
			<div class="controls">
				<select name="device_id">
				<? foreach ($devices as $device) : ?>
				<option value="<?=$device->id?>" <? if ($device_id == $device->id) echo 'selected'?>><?=$device->name?></option>
				<? endforeach ?>
				</select>
			</div>
			
		</div>
	</div>
	
	<div class="row-container">
		<div class="control-group">
			<label class="control-label">Time:</label>
			<div class="controls">
				<input type="text" name="time" value="<?=$time?>"> <span class="help-inline">(YYYY-MM-DD HH:MM)</span>
			</div>
			
		</div>
	</div>

    <div class="row-container">
		<div class="control-group">
			<label class="control-label">Low battery:</label>
			<div class="controls">
				<input type="checkbox" name="low_battery" <?php if ($low_battery) echo 'checked="checked"' ?> value="1"/>
			</div>

		</div>
	</div>
	
	<div class="form-actions">
		<button type="submit" class="btn btn-success btn-large">Get Code</button>
	</div>
	
	<? if (!empty($code)) : ?>
	<div class="alert alert-success"><strong>Code: </strong><?=$code?></div>
	<? endif ?>
	
	<div class="alert alert-info">
	<strong>Device ID: </strong><?=$device_id?><br />
	<strong>Device Code: </strong><?=$initial_timecode?><br />
	<strong>Device initial time: </strong><?= (!empty($initial_timestamp)) ? date("Y-m-d H:i:s", $initial_timestamp) : ''?><br />
	<strong>Device initial timestamp: </strong><?=$initial_timestamp?><br />
	<strong>Requested time: </strong><?=$time?><br />
	<strong>Requested timestamp: </strong><?=$timestamp?><br />
	<strong>Elapsed minutes: </strong><?=$minutes_elapsed?><br />
	<strong>Account Secret Key: </strong><?=$secret_key?><br />
	</div>
	
	
</form>
