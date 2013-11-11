<h1>Add User Group</h1>

<? if ($error) : ?>
<div class="alert alert-error"><strong>Error: </strong><?=$error?></div>
<? endif ?>

<form class="form-horizontal" action="" method="post">
	
		<div class="form-group">
			<div class="col-lg-3">
	    		<label>Name of Group</label>
	    		<input type="text" name="name" value="<?=$usergroup->name?>" class="form-control">
	  		</div>
	  	</div>
	<? $this->load->view('usergroups/permissions', compact('entities','actions')) ?>
	<div class="form-group">
		<button type="submit" class="btn btn-success">Submit</button>
	</div>
</form>
