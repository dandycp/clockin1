<h1>Add Client</h1>

<p>To add a new client to your account, please ask for their Clock In Point Account Number, and enter it below.</p>

<? if ($error) : ?>
<div class="alert alert-error"><strong>Error: </strong><?=$error?></div>
<? endif ?>

<form class="form-horizontal" action="" method="post">
	

	<div class="form-group">
    	<label for="inputEmail1" class="col-lg-2 control-label">Account Number</label>
    		<div class="col-lg-4">
      			<input type="text" class="form-control" name="account_number" value="<?=$data['account_number']?>">
      	
    		</div>
  	</div>
	<div class="form-actions">
		<button type="submit" class="btn btn-success btn-large">Submit</button>
	</div>
</form>
