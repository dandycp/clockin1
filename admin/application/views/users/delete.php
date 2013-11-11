<h1>Delete User</h1>

<? if ($error) : ?>
<div class="alert alert-error"><strong>Error: </strong><?=$error?></div>
<? else : ?>
<p class="text-warning">Are you sure you definitely wish to delete this User?</p>
<? endif ?>

<form class="form-horizontal" action="" method="post">
<input type="hidden" name="id" value="<?=$user->id?>" />
	<div class="control-group">
		<label class="control-label">Name:</label>
		<div class="controls">
			<input type="text" name="name" value="<?=$user->username?>" disabled="disabled" />
		</div>
	<div class="form-actions">
		<a href="users" class="btn btn-large">Cancel</a>
		<button type="submit" class="btn btn-success btn-large">Delete</button>
	</div>
</form>