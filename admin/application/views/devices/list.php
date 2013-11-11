<h2>Devices</h2>
<? if ($message = $this->session->flashdata('message')) : ?>
<div class="alert alert-success"><strong>Info: </strong> <?=$message?></div>
<? endif ?>
	
	<div class="pull-left">
		<a class="btn btn-success" href="<?php echo site_url(); ?>clients/devices/add">Add new Device</a>
		<a class="btn btn-primary" href="<?php echo site_url(); ?>clients/devices/upload_step_1">Upload Bulk</a>
	</div>
		<form class="form-inline pull-right" role="form" action="<?php echo site_url(); ?>clients/devices/device_search" method="post">
		  <div class="form-group">
			<div class="col-lg-15">
		    <label class="sr-only">Email address</label>
		    <input type="text" class="form-control" name="term" placeholder="Search...">
		  </div>
		  </div>
		  <button type="submit" class="btn btn-primary">Search</button>
		</form>



<? if ($devices) : ?>
<table class="table table-striped table-condensed">
<thead>
<tr><th>Name</th><th>Address</th><th>Location</th><th>Actions</th></tr>
<tbody>
<? foreach ($devices as $device) : ?>
<tr>
<td><?php if ($device->calibration != 1) { echo '<a title="Device not calibrated"><img src="'.site_url().'images/ex.png" width="20"></a>'; } ?>&nbsp;&nbsp;<a href="<?php echo site_url(); ?>clients/devices/edit/<?=$device->id?>" title="View <?=$device->name?> - Device ID: <?=$device->id?>"><?=$device->name?></a></td>
<td><?=$device->address->full_address()?></td>
<td><?=$device->location?></td>
<td>
<?php
$this->load->library('session');

$devicedata = array('device_id' => $device->id, 'device_name' => $device->name);

$this->session->set_userdata($devicedata);
//var_dump($devicedata);
?>
<a class="btn btn-default" href="<?php echo site_url(); ?>clients/devices/check/<?php echo $this->session->userdata('device_id'); ?>"><i class="icon-wrench"></i> Re-calibrate</a>
<a class="btn btn-warning" href="<?php echo site_url(); ?>clients/devices/edit/<?=$device->id?>"><i class="icon-edit"></i> Settings</a>
<a class="btn btn-danger" href="<?php echo site_url(); ?>clients/devices/delete/<?=$device->id?>"><i class="icon-remove"></i> Delete</a>
</td>
</tr>
<? endforeach ?>
</tbody>
</table>
<? else : ?>
<br /><br /><div class="alert alert-info pull-left"><strong>Notice: </strong>You do not have any devices currently set up</div>
<? endif ?>