<h1>Create account</h1>

<? if ($error) : ?>
<div class="alert alert-error"><strong>Error: </strong><?=$error?></div>
<? endif ?>

<form action="" method="post" class="form-horizontal">
	
	<div class="row">

	<legend><span>Contact Details</span></legend>
	
	<fieldset class="span6">
		
		<div class="control-group">
		<label class="control-label">Title:</label>
		<div class="controls">
		<select name="title">
		<option <? if ($user->title=='Mr') echo 'selected="selected"' ?>>Mr</option>
		<option <? if ($user->title=='Mrs') echo 'selected="selected"' ?>>Mrs</option>
		<option <? if ($user->title=='Ms') echo 'selected="selected"' ?>>Ms</option>
		</select>
		</div>
		</div>
		
		<div class="control-group">
		<label class="control-label">First Name:</label>
		
		<div class="controls">
		<input type="text" name="first_name" value="<?=$user->first_name?>">
		</div>
		
		</div>
		
		<div class="control-group">
		<label class="control-label">Surname:</label>
		
		<div class="controls">
		<input type="text" name="last_name" value="<?=$user->last_name?>">
		</div>
		
		</div>
        
        
        <div class="control-group">
		<label class="control-label">Tel:</label>
		<div class="controls">
		<input type="text" name="tel" value="<?=$user->tel?>">
		</div>
		</div>
		
		<div class="control-group">
		<label class="control-label" name="email">Email:</label>
		<div class="controls">
		<input type="text" name="email" value="<?=$user->email?>">
		</div>
		</div>
		
		<div class="control-group">
		<label class="control-label">Confirm Email:</label>
		<div class="controls">
		<input type="text" name="email2" value="<?=@$data['email2']?>">
		</div>
		</div>

	</fieldset>
	
	
	<fieldset class="span6">
        
        <? $this->load->view('common/address', compact('address', 'countries')) ?>
	
	</fieldset>
	
	</div>
	
	<div class="row">
	
	<fieldset>
	
		
		<legend><span>Account Details</span></legend>
		
		<div class="span6">
		
		<div class="control-group">
		<label class="control-label">Company:</label>
		
		<div class="controls">
		<input type="text" name="company_name" value="<?=$account->company_name?>">
		</div>
		
		</div>
		
		

		<div class="form-group">
	  	<div class="col-lg-4">
		<label>Business Type</label>
		
	
			<select name="business_type" class="form-control">
				<option value="Home/Basic User" selected="selected">Home/Basic User</option>
				<option value="Commercial/Industrial">Commercial/Industrial</option>
				<option value="Education">Education</option>
				<option value="Health/adult Social Care">Health/adult Social Care</option>
				<option value="HR/facilities Management">HR/facilities Management</option>
				<option value="Public Sector">Public Sector</option>
				<option value="Retail">Retail</option>
				<option value="Social Housing">Social Housing</option>
				<option value="Other">Other</option>
			</select>
	
		</div>
	</div>
		
		<div class="control-group">
		
		<label class="control-label">Please choose the option that most closely represents your needs:</label>
		
		<div class="controls">
		
		<label class="radio">
		<input type="radio" name="type" value="basic" <?=($account->type=='basic')?'checked="checked"':''?> />
		<strong>Device Owner</strong> - you own your own devices
		</label>
		
		<label class="radio">
		<input type="radio" name="type" value="provider" <?=($account->type=='provider')?'checked="checked"':''?> />
		<strong>Service Provider</strong> - you will be entering codes for a client
		</label>
		</div>
		</div>

		<div class="form-group">
			<div class="col-lg-4">
	    		<label>Tolerance Rate</label>
	    		<input type="text" name="tolerance_rate" value="<?php echo $account->tolerance_rate; ?>" class="form-control"/>
	    		<div class="help-block">Set the rate of which you allow users to enter codes. If the rate is breached you will be notifed by email.</div>
	  		</div>
	  	</div>
		
		</div>
		<div class="span6">
		
		<div class="control-group">
		<label class="control-label">Password:</label>
		<div class="controls">
		<input type="password" name="password">
		</div>
		</div>
		
		<div class="control-group">
		<label class="control-label">Confirm Password:</label>
		<div class="controls">
		<input type="password" name="password2">
		</div>
		</div>
		
		<div class="control-group">
		<div class="controls">
		<input type="checkbox" name="agree_to_terms" style="margin:-5px 10px 0 0;">I agree to Clock In Point's <a href="#">Terms of Services</a> and <a href="#">Privacy Policy</a>.
		</div>
		</div>
	
	
		
		
		</div>
	
	
	</fieldset>
	
	</div>
	
	<div class="form-actions">
		<button type="submit" class="btn btn-success btn-large pull-right">Continue To Step 2</button>
	</div>
	
	
</form>
