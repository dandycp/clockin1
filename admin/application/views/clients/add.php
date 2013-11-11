<h1>Add Client</h1>

<p>To add a new client to your account, please ask for their Clock In Point Account Number, and enter it below.</p>

<? if ($error) : ?>
<div class="alert alert-error"><strong>Error: </strong><?=$error?></div>
<? endif ?>

<form class="form-horizontal" action="" method="post">
	<div class="control-group">
		<label class="control-label">Account Number:</label>
		<div class="controls">
			<input type="text" name="account_number" value="<?=$data['account_number']?>" autofocus class="form-control" style="width: 230px;">
		</div>
	</div>
	<div class="form-actions">
		<button type="submit" class="btn btn-success btn-large">Submit</button>
	</div>
</form>
<br />
Alternatively please click <a href="<?php echo site_url(); ?>">here</a> to login to your account
