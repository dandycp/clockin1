<h1>People / Staff</h1>

<a class="btn btn-success" href="<?php echo site_url(); ?>clients/people/add"><i class="icon-plus"></i> Add new Person</a>
<a class="btn btn-primary" href="<?php echo site_url(); ?>clients/people/upload">Upload Bulk</a>

<? if ($message = $this->session->flashdata('message')) : ?>
<div class="alert alert-success"><strong>Info: </strong> <?=$message?></div>
<? endif ?>

<? if ($people) : ?>
<table class="table table-striped">
<thead>
<tr><th>Name</th><th>Actions</th></tr>
<tbody>
<? foreach ($people as $person) : ?>
<tr>
<td><?=$person->name?></td>
<td>
<a class="btn btn-warning" href="<?php echo site_url(); ?>clients/people/edit/<?=$person->id?>"><i class="icon-pencil"></i> Edit</a> 
<a class="btn btn-danger" href="<?php echo site_url(); ?>clients/people/delete/<?=$person->id?>"><i class="icon-remove"></i> Delete</a>
</td>
</tr>
<? endforeach ?>
</tbody>
</table>

<? else : ?>
<p class="alert aler-info"><strong>You do not currently have any people set up.</strong><br />
You can set up a list of people/staff on your account. This allows you to optionally select which member of staff a particular log entry applies to for reporting purposes.</p>
<? endif ?>
