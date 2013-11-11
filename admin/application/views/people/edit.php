<h1>Edit Person</h1>

<? if ($error) : ?>
<div class="alert alert-error"><strong>Error: </strong><?=$error?></div>
<? endif ?>

<form action="" method="post" class="form-horizontal">
		
	
		<div class="form-group">
			<div class="col-lg-3">
	    		<label>Name</label>
	    		<input type="text" name="name" value="<?=$person->name?>" class="form-control" />
	    		<label class="control-label" for="inputError"><?php echo form_error('name', '<div class="txt-alert">', '</div>'); ?></label>
	  		</div>
	  	</div>


		<div class="form-group">
			<div class="col-lg-3">
	    		<label>Manager/Dept</label>
	    		<input type="text" name="dept" value="<?=$person->dept?>" class="form-control" />
	    		<label class="control-label" for="inputError"><?php echo form_error('dept', '<div class="txt-alert">', '</div>'); ?></label>
	  		</div>
	  	</div>
	
	<div class="form-group">
		<div class="col-lg-1">
		<button type="submit" class="btn btn-success btn-large">Save</button>
	</div>
	</div>
</form>

