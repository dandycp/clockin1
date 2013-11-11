<h1>Add Work Description</h1>

<? if ($error) : ?>
<div class="alert alert-error"><strong>Error: </strong><?=$error?></div>
<? endif ?>

<form action="" method="post" class="form-horizontal">
		
		<div class="form-group">
			<div class="col-lg-3">
	    		<label>Name</label>
	    		<input type="text" name="name" value="<?=$category->name?>" autofocus class="form-control">
	    		<span class="help-inline">eg: Plumbing Work, Boiler Service etc</span>
	  		</div>
	  	</div>

	  	<div class="form-group">
			<div class="col-lg-3">
	    		<label>Notes/Comments</label>
	    		<textarea class="form-control" name="notes" rows="5"><?=$category->notes?></textarea>
	    		<span class="help-inline">Comments about the service</span>
	  		</div>
	  	</div>
	
		<div class="form-group">
			<div class="col-lg-1">
				<button type="submit" class="btn btn-success">Create</button>
			</div>
		</div>
</form>

