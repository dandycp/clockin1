<h1>My Clients</h1>
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
<td><?=$contract->approved ? 'Approved' : 'Pending' ?></td>
<td>
<a class="btn btn-small" href="clients/delete/<?=$contract->id?>"><i class="icon-remove"></i> Delete</a>
</td>
</tr>
<? endforeach ?>
</tbody>
</table>

<? else : ?>
<div class="alert">You do not currently have any clients in place.</div>
<? endif ?>

<a class="btn btn-small" href="clients/add"><i class="icon-plus"></i> Add new Client</a>