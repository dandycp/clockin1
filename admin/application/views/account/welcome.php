<h2>Welcome, please use the navigation panel above to get started.</h2>

<!--<img src="http://clockinpoint.com/img/feature-image-internal.gif" alt="" width="100%" />-->
<div class="well" style="margin: 15px 0px 5px 0px;">
	User: <strong><?=$this->user->first_name?></strong><br />
	Access: <strong>Basic</strong><br />
	Company: <strong><?php echo $this->account->company_name; ?></strong><br />
	Account Number: <strong><?=$this->account->account_number?></strong>
	

</div>


<? if ($this->account->type == 'basic' && !$this->account->show_clients) : ?>
<div class="alert alert-error">
You currently have a Basic User Account, which only allows you to register and use a limited online service for 1 device. If you wish to add more devices, or access additional reporting functions, <a href="account/upgrade_benefits">click here</a></div>
<? endif ?>

<? if ($message = $this->session->flashdata('message')) : ?>
<div class="alert alert-success"><strong>Info: </strong> <?=$message?></div>
<? endif ?>

<!-- removed not needed
<ul class="nav nav-list">
	
	<li><a href="codes/enter" class="link-but">Enter Clock In Point codes</a></li>
	
	<? if ($this->account->type == 'pro') : ?>
	<li><a href="devices/add" class="link-but">Add/Register Clock In Point device</a></li>
	<? endif ?>
	
	<li><a href="account/edit" class="link-but">Change Account Settings</a></li>
	
	<? if ($this->account->type == 'pro') : ?>
	<li><a href="providers/add" class="link-but">Add Service Provider</a></li>
	<? endif ?>
	
	<li><a href="reports" class="link-but">View History Logs</a></li>
	
</ul>
<hr>
-->

<? if ($this->account->type == 'basic' && $device) : ?>
<h2>Current device registered</h2>
<p>Address: <?=$device->address->full_address()?><br />
Location Of Device: <?=$device->location?><br />
Device ID: <?=$device->id?></p>
<a href="devices/edit/<?=$device->id?>" class="btn">Edit device</a>
<? endif ?>

