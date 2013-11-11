<h1>Add People</h1>

<? if ($error) : ?>
<div class="alert alert-error"><strong>Error: </strong><?=$error?></div>
<? endif ?>

<h4>Enter people who will be carrying out works</h4>

<p style="font-size: 11px;"><span style="color: red;">*</span> indicates required fields</p>
<form action="" method="post" class="form-horizontal">
		

		<div class="form-group">
			<div class="col-lg-3">
	    		<label><span style="color: red;">*</span>Name</label>
	    		<input type="text" name="name" value="<?=$person->name?>" class="form-control"/>
	    		<label class="control-label" for="inputError"><?php echo form_error('name', '<div class="txt-alert">', '</div>'); ?></label>
	  		</div>
	  	</div>

	
		<div class="form-group">
			<div class="col-lg-3">
	    		<label><span style="color: red;">*</span>Manager/Dept:</label>
	    		<input type="text" name="dept" value="<?=$person->dept?>" class="form-control">
			<label class="control-label" for="inputError"><?php echo form_error('dept', '<div class="txt-alert">', '</div>'); ?></label>
	  		</div>
	  	</div>

			
	<div class="form-group">
		<div class="col-lg-3">
		<button class="btn btn-primary">Add another person</button>
		<button type="submit" class="btn btn-success">Save</button>
	</div>
	</div>
</form>



