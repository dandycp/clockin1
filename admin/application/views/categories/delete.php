<h1>Delete Work Description</h1>

<? if ($error) : ?>
<div class="alert alert-error"><button type="button" class="close" aria-hidden="true">&times;</button>
<strong>Error: </strong><?=$error?></div>
<? else : ?>
<p class="alert alert-info">Are you sure you wish to delete this work description?<br />This cannot be undone.</p>
<? endif ?>

<form class="form-horizontal" action="" method="post">
<input type="hidden" name="id" value="<?=$category->id?>" />
	
	<div class="form-group">
			<div class="col-lg-3">
	    		<label>Name</label>
	    		<input type="text" name="name" value="<?=$category->name?>" disabled="disabled" class="form-control">
	    		
	  		</div>
	  	</div>

		<div class="form-group">
			<div class="col-lg-3">
				<a href="<?php echo site_url(); ?>clients/categories" class="btn btn-danger">Cancel</a>
				<button type="submit" class="btn btn-success">Delete</button>
			</div>
		</div>
</form>