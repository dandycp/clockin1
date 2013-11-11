<h1>Add User</h1>

<? if ($error) : ?>
<div class="alert alert-error"><strong>Error: </strong><?=$error?></div>
<? endif ?>

<form action="" method="post" class="form-horizontal">
	
	<fieldset>
		<legend><span>Personal Details</span></legend>
		
		<div class="form-group">
			<label class="control-label">First Name:</label>
		
			<div class="col-lg-3">
			<input type="text" name="first_name" value="<?=$user->first_name?>" class="form-control">
			</div>
		
		</div>
		
		<div class="form-group">
		<label class="control-label">Last Name:</label>
		
		<div class="col-lg-3">
		<input type="text" name="last_name" value="<?=$user->last_name?>" class="form-control">
		</div>
		
		</div>

		<div class="form-group">
		<label class="control-label">Tel:</label>
		<div class="col-lg-3">
		<input type="text" name="tel" value="<?=$user->tel?>" class="form-control">
		</div>
		</div>
	
	</fieldset>
	
	<fieldset>
	
		<legend><span>Account Details</span></legend>
		
		<div class="form-group">
		<label class="control-label">User Group:</label>
		<div class="col-lg-3">
		<select name="usergroup_id" class="form-control">
			<option value="">Please Select</option>
			<? foreach ($usergroups as $usergroup) : ?>
			<option value="<?=$usergroup->id?>"><?=$usergroup->name?></option>
			<? endforeach ?>
		</select>
		</div>
		</div>
		
		<div class="form-group">
		<label class="control-label" name="email">Email:</label>
		<div class="col-lg-3">
		<input type="text" name="email" value="<?=$user->email?>" class="form-control">
		</div>
		</div>
		<div class="form-group">
		<label class="control-label">Password:</label>
		<div class="col-lg-3">
		<input type="text" name="password" value="<?=$user->password?>" class="form-control">
		</div>
		</div>

		<div class="form-group">
		<label class="control-label" name="email">Manager:</label>
		<div class="col-lg-3">
		<input type="text" name="manager" value="<?=$user->manager?>" class="form-control">
		</div>
		</div>

		<div class="form-group">
		<label class="control-label" name="email">Dept:</label>
		<div class="col-lg-3">
		<input type="text" name="dept" value="<?=$user->dept?>" class="form-control">
		</div>
		</div>
		
	
	
	</fieldset>
	
	<div class="form-group">
		<div class="col-lg-3"><button type="submit" class="btn btn-success btn-large">Save</button></div>
	</div>
</form>

