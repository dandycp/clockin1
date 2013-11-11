<h1>Edit User</h1>

<? if ($error) : ?>
<div class="alert alert-error"><strong>Error: </strong><?=$error?></div>
<? endif ?>

<form action="" method="post" class="form-horizontal" role="form">
	
	<fieldset>
		<legend><span>Contact Details</span></legend>
		
		<div class="form-group">
			<div class="col-lg-2">
	    		<label>Title</label>
	    		<select name="title" class="form-control">
					<option <? if ($user->title=='Mr') echo 'selected="selected"' ?>>Mr</option>
					<option <? if ($user->title=='Mrs') echo 'selected="selected"' ?>>Mrs</option>
					<option <? if ($user->title=='Ms') echo 'selected="selected"' ?>>Ms</option>
					</select>
	  		</div>
  		</div>

  		<div class="form-group">
			<div class="col-lg-3">
	    		<label>First Name</label>
	    		<input type="text" name="first_name" value="<?=$user->first_name?>" class="form-control">
	  		</div>
	  	</div>

  		<div class="form-group">
			<div class="col-lg-3">
	    		<label>Last Name</label>
	    		<input type="text" name="last_name" value="<?=$user->last_name?>" class="form-control">
	  		</div>
	  	</div>

		
		<div class="form-group">
			<div class="col-lg-3">
	    		<label>Phone</label>
	    		<input type="text" name="tel" value="<?=$user->tel?>" class="form-control">
	  		</div>
	  	</div>
		
		<? if ($can_edit_usergroup) : ?>
		
		<div class="form-group">
			<div class="col-lg-3">
	    		<label>User Group</label>
	    		<select name="usergroup_id" class="form-control">
					<option value="">Please Select</option>
					<? foreach ($usergroups as $usergroup) : ?>
					<option value="<?=$usergroup->id?>" <? if ($user->usergroup->id == $usergroup->id) echo 'selected="selected"'?>><?=$usergroup->name?></option>
					<? endforeach ?>
				</select>
	  		</div>
	  	</div>

		
		<? endif ?>
		
		<div class="form-group">
			<div class="col-lg-3">
	    		<label>Email</label>
	    		<?php if (valid_email($user->email)) { ?> 
					<input type="text" name="email" value="<?=$user->email?>" id="inputSuccess" class="form-control">
				<?php } 
				else { ?>
					<input type="text" name="email" value="<?=$user->email?>" id="inputError" class="form-control">
				<?php } ?>
	  		</div>
	  	</div>

	  	<div class="form-group">
			<div class="col-lg-3">
	    		<label>Password</label>
	    		<input type="password" name="password" value="" class="form-control"><span class="help-inline">Leave for unchanged.</span>
	  		</div>
	  	</div>

	  	<div class="form-group">
	  	<div class="col-lg-3">
		<label>Manager</label>
		
			<input type="text" name="manager" value="<?=$user->manager?>" class="form-control">
		</div>
		</div>

		<div class="form-group">
		<div class="col-lg-3">
		<label>Dept</label>
		
			<input type="text" name="dept" value="<?=$user->dept?>" class="form-control">
		</div>
		</div>
	

	
	
	</fieldset>
	
	<div class="form-group">
		<div class="col-lg-1">
			<button type="submit" class="btn btn-success btn-large">Save</button>
		</div>
	</div>
</form>

