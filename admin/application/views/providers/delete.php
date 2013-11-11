<h1>Delete Provider</h1>
<p class="red">Are you sure you definitely wish to delete this Provider?</p>
<form class="form-inline" action="" method="post" role="form">
<input type="hidden" name="id" value="<?=$provider->id?>" />
	<table>
		<tr>
			<td><label>Company Name</label>&nbsp;</td>
			<td><input type="text" class="form-control" name="name" value="<?=$provider->company_name?>" disabled="disabled"></td>
		</tr>
		<tr><td><br /></td><td></td></tr>
		<tr>
			<td><a href="<?php echo site_url(); ?>clients/providers" class="btn btn-warning">Cancel</a></td>
			<td><button type="submit" class="btn btn-success">Delete</button></td>
		</tr>
	</table>
</form>