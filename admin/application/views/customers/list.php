<h1>My Clients</h1>
<div class="well">
	<a class="btn btn-success" href="<?php echo site_url(); ?>customers/add"><span class="glyphicon glyphicon-plus"></span> Add new Client</a>
</div>
<? if ($message = $this->session->flashdata('message')) : ?>
<div class="alert alert-success"><strong>Info: </strong> <?=$message?></div>
<? endif ?>

<? if ($contracts) : ?>
<table class="table table-striped">
<thead>
<tr><th>Account Number</th><th>Company Name</th><th>Contact Name</th><th>Email</th><th>Tel</th><th>Approval</th><th>Actions</th></tr>
<tbody>
<? foreach ($contracts as $contract) : ?>
<tr>
<td><?=$contract->client->account_number?></td>
<td><?=$contract->client->name()?></td>
<td><?=$contract->client->contact_name()?></td>
<td><?=auto_link($contract->client->email())?></td>
<td><?=$contract->client->tel()?></td>
<td><?=$contract->approved ? '<span class="green">Approved</span>' : '<span class="red">Pending</span>' ?></td>
<td>
	<? if (!$contract->approved) : ?>
	<a class="btn btn-success" href="<?php echo site_url(); ?>customers/approve/<?=$contract->id?>"><span class="glyphicon glyphicon-ok"></span> Approve</a>
	<? else : ?>
	<a class="btn btn-warning" href="<?php echo site_url(); ?>customers/reject/<?=$contract->id?>"><span class="glyphicon glyphicon-minus"></span> Decline</a>
	<a class="btn btn-danger" href="<?php echo site_url(); ?>customers/delete/<?=$contract->id?>"><span class="glyphicon glyphicon-remove"></span> Remove</a>
	<? endif ?>
</td>
</tr>
<? endforeach ?>
</tbody>
</table>

<? else : ?>
<div class="alert">You do not currently have any clients in place.</div>
<? endif ?>

