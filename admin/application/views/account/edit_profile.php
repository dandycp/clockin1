<h1>Edit user details</h1>

<div class="well">Account Number: <strong><?=$this->user->get_owner()->account_number?></strong></div>

<? if ($message = $this->session->flashdata('message')) : ?>
<div class="alert alert-success"><strong>Info: </strong> <?=$message?></div>
<? endif ?>

<? if ($error) : ?>
<div class="alert alert-error"><strong>Error: </strong><?=$error?></div>
<? endif ?>
    
<form action="" class="form-horizontal" method="post">
 <fieldset>

<legend><span>Personal Details</span></legend>

<div class="control-group">
<label class="control-label">Title:</label>
<div class="controls">
<select name="title">
<option <? if ($profile->title=='Mr') echo 'selected="selected"' ?>>Mr</option>
<option <? if ($profile->title=='Mrs') echo 'selected="selected"' ?>>Mrs</option>
<option <? if ($profile->title=='Ms') echo 'selected="selected"' ?>>Ms</option>
</select>
</div>
</div>

<div class="control-group">
<label class="control-label">First Name:</label>

<div class="controls">
<input type="text" name="first_name" value="<?=$profile->first_name?>">
</div>

</div>

<div class="control-group">
<label class="control-label">Surname:</label>

<div class="controls">
<input type="text" name="last_name" value="<?=$profile->last_name?>">
</div>

</div>

<? //$this->load->view('common/address', compact('address', 'countries')) ?>

</fieldset>
<fieldset>

<legend><span>Contact Details</span></legend>

<div class="control-group">
<label class="control-label">Tel:</label>
<div class="controls">
<input type="text" name="tel" value="<?=$profile->tel?>">
</div>
</div>

<div class="control-group">
<label class="control-label" name="email">Email:</label>
<div class="controls">
<input type="text" name="email" value="<?=$profile->email?>">
</div>
</div>

<div class="control-group">
<label class="control-label">Confirm Email:</label>
<div class="controls">
<input type="text" name="email2" value="">
</div>
</div>

</fieldset>


<fieldset>

<legend><span>Business Details</span></legend>


<div class="control-group">
<label class="control-label">Company Name:</label>
<div class="controls">
<input type="text" name="company_name" value="<?=$profile->company_name?>">
</div>
</div>

<div class="control-group">
<label class="control-label">Business Type:</label>
<div class="controls">
<input type="text" name="business_type" value="<?=$profile->business_type?>">
</div>
</div>

</fieldset>



<fieldset>

<legend><span>Account Details</span></legend>


<div class="control-group">
<label class="control-label">Change Password:</label>
<div class="controls">
<input type="password" name="password">
</div>
</div>

<div class="control-group">
<label class="control-label">Confirm New Password:</label>
<div class="controls">
<input type="password" name="password2">
</div>
</div>

</fieldset>




    <div class="form-actions">
    <button type="submit" class="btn btn-success btn-large">Edit Details</button>
    </div>

</form>
      


