<h1>Delete Person</h1>

<? if ($error) : ?>
<div class="alert alert-error"><strong>Error: </strong><?=$error?></div>
<? else : ?>
<p class="alert alert-info">Are you sure you wish to delete this Person?</p>
<? endif ?>

<form class="form-horizontal" action="" method="post">
<input type="hidden" name="id" value="<?=$person->id?>" />
	
	<div class="form-group">
			<div class="col-lg-3">
	    		<label>Name</label>
	    		<input type="text" name="name" value="<?=$person->name?>" disabled="disabled" class="form-control" />
	  		</div>
	  	</div>

	  	<div class="form-group">
			<div class="col-lg-3">
	    		<label>Manager / Dept</label>
	    		<input type="text" name="dept" value="<?=$person->dept?>" disabled="disabled" class="form-control" />
	  		</div>
	  	</div>
	<div class="form-group">
		<div class="col-lg-3">
		<a href="<?php echo site_url(); ?>clients/people" class="btn btn-danger">Cancel</a>
		<button type="submit" class="btn btn-success">Delete</button>
	</div>
	</div>
</form>