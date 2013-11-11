<h1>Edit User Group</h1>

<? if ($error) : ?>
<div class="alert alert-error"><strong>Error: </strong><?=$error?></div>
<? endif ?>

<form class="form-horizontal" action="" method="post">
	<div class="control-group">
		<label class="control-label">Name of Group</label>
		<div class="col-lg-4">
			<input type="text" name="name" value="<?=$usergroup->name?>" class="form-control" />
		</div>
	</div>
	<? $this->load->view('usergroups/permissions', compact('actions')) ?>
	<div class="form-group">
		<button type="submit" class="btn btn-success btn-large">Submit</button>
	</div>
</form>
