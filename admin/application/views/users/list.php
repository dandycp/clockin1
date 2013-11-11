<h1>My Users</h1>
<? if ($message = $this->session->flashdata('message')) : ?>
<div class="alert alert-success"><strong>Info: </strong> <?=$message?></div>
<? endif ?>

<div class="row-fluid show-grid">
	<div class="span4">
		<h2>User Groups</h2>
		<? if ($usergroups) : ?>
		<table class="table table-striped">
		<thead>
		<tr><th>Name</th><th>Actions</th></tr>
		<tbody>
		<? foreach ($usergroups as $usergroup) : ?>
		<tr>
		<td><?=$usergroup->name?></td>
		<td>
		<a class="btn btn-warning" href="usergroups/edit/<?=$usergroup->id?>"><i class="icon-pencil"></i> Edit</a>
		<a class="btn btn-danger" href="usergroups/delete/<?=$usergroup->id?>"><i class="icon-remove"></i> Delete</a>
		</td>
		</tr>
		<? endforeach ?>
		</tbody>
		</table>
		
		<? else : ?>
		<div class="alert">You do not currently have any user groups set up.</div>
		<? endif ?>
		
		<a class="btn btn-primary" href="<?php echo site_url(); ?>clients/usergroups/add"><i class="icon-plus"></i> Add new User Group</a>
	</div>
	<div class="span8">
		<h2>Users</h2>
		<? if ($users) : ?>
		<table class="table table-striped">
		<thead>
		<tr><th>User Group</th><th>Name</th><th>Email</th><th>Actions</th></tr>
		<tbody>
		<? foreach ($users as $user) : ?>
		<tr>
		<td><?=$user->usergroup->name?></td>
		<td><?=$user->username?></td>
		<td><?=auto_link($user->email)?></td>
		<td>
		<a class="btn btn-warning" href="<?php echo site_url(); ?>clients/users/edit/<?=$user->id?>"><i class="icon-pencil"></i> Edit</a> 
		<a class="btn btn-danger" href="<?php echo site_url(); ?>clients/users/delete/<?=$user->id?>"><i class="icon-remove"></i> Delete</a>
		</td>
		</tr>
		<? endforeach ?>
		</tbody>
		</table>
		
		<? else : ?>
		<div class="alert">You do not currently have any users set up.</div>
		<? endif ?>
		
		<? if ($usergroups) : ?>
		<a class="btn btn-primary" href="<?php echo site_url(); ?>clients/users/add"><i class="icon-plus"></i> Add new User</a>
		<? else : ?>
		<a class="btn btn-primary disabled"><i class="icon-plus"></i> Add new User</a>
		<? endif ?>
	
	</div>
</div>

