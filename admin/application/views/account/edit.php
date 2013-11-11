<h1>Account Settings</h1>
<? if ($message = $this->session->flashdata('message')) : ?>
<div class="alert alert-success"><strong>Info: </strong> <?=$message?></div>
<? endif ?>

<? if ($error) : ?>
<div class="alert alert-error"><strong>Error: </strong><?=$error?></div>
<? endif ?>


	<div class="panel panel-default pull-left"  style="width: 49%;">
		<div class="panel-heading">Account Details</div>

		<div class="panel-body">
			<table>
				<tr><td><strong>Account Number:</strong> <?=$this->account->account_number?></td></tr>
				<tr><td><strong>Account Type:</strong> <?=ucfirst($account->type)?></td></tr>
				<tr><td><strong>Device Limit:</strong> <?=$account->device_limit?></td></tr>
			</table>
			
			<p><a href="<?php echo site_url(); ?>clients/account/change_package" class="btn btn-primary">Change / Upgrade</a></p>
		</div>
	</div>

	<div class="panel panel-default pull-right"  style="width: 49%;">
		<div class="panel-heading">Financial Details</div>

		<div class="panel-body">
			<? if ($card) : ?>
			<table>
				<tr><td><strong>Card Type: </strong><?=$card->type?></td></tr>
				<tr><td><strong>Card Number: </strong>**** **** **** <?=$card->last_4_digits?></td></tr>
				<tr><td><strong>Expires: </strong><?=$card->get_expiry_date()?></td></tr>
				<tr><td><a href="<?php echo site_url(); ?>clients/payments/add_card" class="btn btn-primary">Replace / Update</a></td></tr>
				<? else : ?>
				<tr><td>You do not currently have an active payment card on your account.</td></tr> 
				<tr><td><a href="<?php echo site_url(); ?>clients/payments/add_card" class="btn btn-primary">Add Card</a></td></tr>
				<? endif ?>
			</table>
		</div>
	</div>

    
<form action="" class="form-horizontal" method="post">


	<legend class="pull-left">Business Details</legend>


		<div class="form-group">
			<div class="col-lg-4">
	    		<label>Company Name</label>
	    		<input type="text" name="company_name" value="<?php echo $account->company_name; ?>" class="form-control"/>
	    		
	  		</div>
	  	</div>


		<div class="form-group">
			<div class="col-lg-4">
	    		<label>Business Type</label>
	    		<input type="text" name="business_type" value="<?php echo $account->business_type; ?>" class="form-control"/>
	    		
	  		</div>
	  	</div>


		<legend><span>Business Address</span></legend>
		<?php echo $this->load->view('common/address', compact('address', 'countries')); ?>


		<div class="form-group">
			<div class="col-lg-4">
	    		<label>Email Notifications</label>
	    		<br /><br />
	    		<?php if ($account->email_notifications !=0) { echo '<span class="alert alert-success">You are receiving email notifications.</span><br /><br /><div class="checkbox">
			    <label>
			      <input type="checkbox" value="0" name="email_notifications"> Don\'t receive email notifications
			    </label>
			  </div>'; } 
	    		else { echo '<span class="alert alert-warning">You are <strong>NOT</strong> receiving email notifications.</span><br /><br /><div class="checkbox">
			    <label>
			      <input type="checkbox" value="1" name="email_notifications"> Yes receive email notfications
			    </label>
			  </div>'; } ?>
	  		</div>
	  	</div>

<br />
		<button type="submit" class="btn btn-success">Save Details</button>

</form>
