<h1>Delete Client</h1>
<p class="text-warning">Are you sure you definitely wish to delete this Client?</p>
<form class="form-horizontal" action="" method="post">
<input type="hidden" name="id" value="<?=$client->id?>" />
	<div class="control-group">
		<label class="control-label">Company Name:</label>
		<div class="controls">
			<input type="text" name="name" value="<?=$client->company_name?>" disabled="disabled" />
		</div>
	<div class="form-actions">
		<a href="clients" class="btn btn-large">Cancel</a>
		<button type="submit" class="btn btn-success btn-large">Delete</button>
	</div>
</form>