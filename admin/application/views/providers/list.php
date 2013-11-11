<h1>My Providers</h1>

<div class="well">
	<a class="btn btn-success" href="<?php echo site_url(); ?>clients/providers/add"><span class="glyphicon glyphicon-plus"></span> Add new Provider</a> 
	<div class="pull-right">Account Number: <strong><?=$this->account->account_number?></strong></div>
</div>

<? if ($message = $this->session->flashdata('message')) : ?>
<div class="alert alert-success"><strong>Info: </strong> <?=$message?></div>
<? endif ?>


<? if ($contracts) : ?>
<table class="table table-striped">
<thead>
	<tr>
		<th>Account Number</th>
		<th>Company Name</th>
		<th>Business Type</th>
		<th>Contact Name</th>
		<th>Email</th>
		<th>Tel</th>
		<th>Approval</th>
		<th>Actions</th>
	</tr>
</thead>
<tbody>
<? foreach ($contracts as $contract) : ?>
<tr>
	<td><?=$contract->provider->account_number?></td>
	<td><?=$contract->provider->name()?></td>
	<td><?=$contract->provider->business_type?></td>
	<td><?=$contract->provider->contact_name?></td>
	<td><?=auto_link($contract->provider->email())?></td>
	<td><?=$contract->provider->tel()?></td>
	<td><?=$contract->approved ? '<span class="label label-success">Approved</span>' : '<span class="label label-danger">Pending</span>' ?></td>
	<td>
		<? if (!$contract->approved) : ?>
		<a class="btn btn-success" href="<?php echo site_url(); ?>clients/providers/approve/<?=$contract->id?>">Approve</a>
		<a class="btn btn-warning" href="<?php echo site_url(); ?>clients/providers/reject/<?=$contract->id?>">Decline</a>
		<? else : ?>
		<a class="btn btn-warning" href="<?php echo site_url(); ?>clients/providers/edit/<?=$contract->provider->account_number?>">Edit</a>
		<a class="btn btn-danger" href="<?php echo site_url(); ?>clients/providers/delete/<?=$contract->id?>">Remove</a>
		<? endif ?>
	</td>
	
</tr>
<? endforeach ?>
</tbody>
</table>

<? else : ?>
<div class="alert alert-info"><strong>You do not currently have any providers in place.</strong> <br />
To add providers, give them your Account Number shown above and request that they create a new Clock In Point account. Once registered they can add you as a client under their 'Clients' section.</div>

<? endif ?>