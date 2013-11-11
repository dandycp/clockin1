<h3>Create Account</h3>
<p>Please select which best suits you</p>
<? if ($error) : ?>
<div class="alert alert-danger"><strong>Error: </strong><?=$error?></div>
<? endif ?>
	<div class="well split" id="do" href="#deviceOwner">
		<h4 style="border: none; margin:9px 0px 9px 9px;">Device Owner</h4>
		<p style="margin:9px 0px 9px 9px;">You own your devices.</p>
	</div>

	<div class="well split" id="sp" href="#serviceProvider">
		<h4 style="border: none; margin:9px 0px 9px 9px;">Service Provider</h4>
		<p style="margin:9px 0px 9px 9px;">You will be entering codes for your clients</p>
	</div>
<script type="text/javascript">
// Code to swap between the two(2) divs show/hide
    $("#do").click(function(){
      $('#device-owner').toggle();
          $("#service-provider").hide()
      });

    $("#sp").click(function(){
      $('#service-provider').toggle();
         $("#device-owner").hide()
      });
</script>
<script type="text/javascript">
$(document).ready(function() { 
	$('#biztypeoptions').change(function(){
	var selected_item = $(this).val()
	if(selected_item == 'Other'){ // 'Other' 
		$('#optionInput').val('').show(); //show textbox if Other is selected
	}
	else {
		$('#optionInput').hide(); //Hide textbox if anything else is selected
	}
	});
});
</script>




	<div id="device-owner">

	          <h4 class="modal-title">Create New Account - Device Owner</h4>

	          	<form role="form" method="post" action="<?php echo site_url('clients/create_account'); ?>" id="deviceAccount" class="form-horizontal" data-validate="parsley">
	          	<input type="hidden" name="type" value="basic" <?=($account->type=='basic')?'checked="checked"':''?>/>
	          			<legend style="border: none!important;"><span>Contact Details</span></legend>
	          				<div class="form-group">
							    <label for="inputEmail1" class="col-lg-4 control-label">Title</label>
							    <div class="col-lg-1">
							        <select name="title" class="form-control">
									<option <? //if ($user->title=='Mr') echo 'selected="selected"' ?>>Mr</option>
									<option <? //if ($user->title=='Mrs') echo 'selected="selected"' ?>>Mrs</option>
									<option <? //if ($user->title=='Ms') echo 'selected="selected"' ?>>Ms</option>
									</select>
							    </div>
  							</div>

							<div class="form-group">
						    	<label for="inputEmail1" class="col-lg-4 control-label">First Name</label>
							    <div class="col-lg-6">
							      <input type="input" class="form-control" id="inputFirstName" name="first_name">
							      <!--<label id="first_name_error"><?php echo form_error('first_name'); ?></label>-->
							    </div>
						    </div>

						    <div class="form-group">
						    	<label for="inputEmail1" class="col-lg-4 control-label">Surname</label>
							    <div class="col-lg-6">
							      <input type="input" class="form-control" id="inputFirstName" name="last_name">
							    </div>
						    </div>

						      	<div class="form-group">
						    	<label for="inputEmail1" class="col-lg-4 control-label">Address</label>
						    		<div class="col-lg-6">
						      			<input type="text" class="form-control" name="address[line_1]" value="<?php echo $address['line_1'];?>">
						    		</div>
						  	</div>


							  <div class="form-group">
							  	<label for="inputEmail1" class="col-lg-4 control-label">Address (optional)</label>
							  	<div class="col-lg-6">
							      <input type="text" class="form-control" name="address[line_2]" value="<?php echo $address['line_2'];?>">
							    </div>
							  </div>

							  <div class="form-group">
							    <label for="inputEmail1" class="col-lg-4 control-label">City/Town</label>
							    <div class="col-lg-6">
							      <input type="text" class="form-control" name="address[city]" value="<?php echo $address['city'];?>">
							    </div>
							  </div>

							  <div class="form-group">
							    <label for="inputEmail1" class="col-lg-4 control-label">Postcode</label>
							    <div class="col-lg-6">
							      <input type="text" class="form-control" name="address[postcode]" value="<?php echo $address['postcode'];?>">
							    </div>
							  </div>

							  <div class="form-group">
							    <label for="inputEmail1" class="col-lg-4 control-label">Country</label>
							    <div class="col-lg-6">
							      <select name="address[country_id]" class="form-control">
									<!--<?php //echo $this->load->view('clients/countries'); ?>-->
									<? foreach ($countries as $country) : ?>
									<option value="<?php echo $country['id'];?>"  <? if ($address['country_id'] == $country['id']) echo 'selected="selected"' ?>>
									<?php echo $country['name'];?>
									</option>
									<? endforeach ?>
								</select>
							    </div>
							  </div>

						    <div class="form-group">
						    	<label for="inputEmail1" class="col-lg-4 control-label">Tel</label>
							    <div class="col-lg-6">
							      <input type="input" class="form-control" id="inputFirstName" name="tel">
							    </div>
						    </div>

						    <div class="form-group">
						    	<label for="inputEmail1" class="col-lg-4 control-label">Email</label>
							    <div class="col-lg-6">
							      <input type="email" class="form-control" id="inputFirstName" name="email">
							    </div>
						    </div>

						    <div class="form-group">
						    	<label for="inputEmail1" class="col-lg-4 control-label">Confirm Email</label>
							    <div class="col-lg-6">
							      <input type="email" class="form-control" id="inputFirstName" name="email2">
							    </div>
						    </div>


						    <legend><span>Account Details</span></legend>
							<!--
						    <div class="form-group">
						    	<label for="inputEmail1" class="col-lg-4 control-label">Company Name</label>
							    <div class="col-lg-6">
							      <input type="input" class="form-control" id="inputFirstName" name="company_name">
							    </div>
						    </div>
							-->
							  <div class="form-group">
							  	
								<label for="inputEmail1" class="col-lg-4 control-label">Business Type</label>
								<div class="col-lg-5">
								<div class="pull-left">
									<select name="business_type" class="form-control" id="biztypeoptions">
										<option value="Home/Basic User" selected="selected">Home/Basic User</option>
										<option value="Commercial/Industrial">Commercial/Industrial</option>
										<option value="Education">Education</option>
										<option value="Health/adult Social Care">Health/adult Social Care</option>
										<option value="HR/facilities Management">HR/facilities Management</option>
										<option value="Public Sector">Public Sector</option>
										<option value="Retail">Retail</option>
										<option value="Social Housing">Social Housing</option>
										<option value="Other" id="optionOther">Other</option>
									</select>
									</div>
									<div class="pull-right">
										<input type="text" name="option-other" id="optionInput" class="form-control" style="display: none;" placeholder="Please specify">
									</div>
								</div>
							  </div>

						    <div class="form-group">
						    	<label for="inputEmail1" class="col-lg-4 control-label">Password</label>
							    <div class="col-lg-6">
							      <input type="password" class="form-control" id="inputFirstName" name="password">
							    </div>
						    </div>
						    <div class="form-group">
						    	<label for="inputEmail1" class="col-lg-4 control-label">Confirm Password</label>
							    <div class="col-lg-6">
							      <input type="password" class="form-control" id="inputFirstName" name="password2">
							    </div>
						    </div>

						    <div class="form-group">
							    <div class="col-lg-10">
							     <input type="checkbox" name="agree_to_terms" style="margin:-5px 10px 0 0;">I agree to Clock In Point's <a href="#">Terms of Services</a> and <a href="#">Privacy Policy</a>.
							    </div>
						    </div>

						    <input type="submit" value="Continue" class="btn btn-primary"/>
	          	</form>
	        </div>
	       
	


	<div id="service-provider">
		<form class="form-horizontal" role="form" method="post" id="service" action="<?php echo site_url('clients/create_account'); ?>">
			<input type="hidden" name="type" value="provider" <?=($account->type=='provider')?'checked="checked"':''?> />
	          <h4 class="modal-title">Create New Account - Service Provider</h4>
	          	
	          			<legend style="border: none;"><span>Contact Details</span></legend>
	          				<div class="form-group">
							    <label for="inputEmail1" class="col-lg-4 control-label">Title</label>
							    <div class="col-lg-1">
							        <select name="title" class="form-control">
									<option <? //if ($user->title=='Mr') echo 'selected="selected"' ?>>Mr</option>
									<option <? //if ($user->title=='Mrs') echo 'selected="selected"' ?>>Mrs</option>
									<option <? //if ($user->title=='Ms') echo 'selected="selected"' ?>>Ms</option>
									</select>
							    </div>
  							</div>

							<div class="form-group">
						    	<label for="inputEmail1" class="col-lg-4 control-label">First Name</label>
							    <div class="col-lg-6">
							      <input type="input" class="form-control" id="inputFirstName" name="first_name">
							      <!--<label class="error" for="first_name" id="first_name_error">This field is required.</label>-->
							    </div>
						    </div>

						    <div class="form-group">
						    	<label for="inputEmail1" class="col-lg-4 control-label">Surname</label>
							    <div class="col-lg-6">
							      <input type="input" class="form-control" id="inputFirstName" name="last_name">
							    </div>
						    </div>

						    <div class="form-group">
						    	<label for="inputEmail1" class="col-lg-4 control-label">Address</label>
						    		<div class="col-lg-6">
						      			<input type="text" class="form-control" name="address[line_1]" value="<?php echo $address['line_1'];?>">
						    		</div>
						  	</div>


							  <div class="form-group">
							  	<label for="inputEmail1" class="col-lg-4 control-label">Address (optional)</label>
							  	<div class="col-lg-6">
							      <input type="text" class="form-control" name="address[line_2]" value="<?php echo $address['line_2'];?>">
							    </div>
							  </div>

							  <div class="form-group">
							    <label for="inputEmail1" class="col-lg-4 control-label">City/Town</label>
							    <div class="col-lg-6">
							      <input type="text" class="form-control" name="address[city]" value="<?php echo $address['city'];?>">
							    </div>
							  </div>

							  <div class="form-group">
							    <label for="inputEmail1" class="col-lg-4 control-label">Postcode</label>
							    <div class="col-lg-6">
							      <input type="text" class="form-control" name="address[postcode]" value="<?php echo $address['postcode'];?>">
							    </div>
							  </div>

							  <div class="form-group">
							    <label for="inputEmail1" class="col-lg-4 control-label">Country</label>
							    <div class="col-lg-6">
							      <select name="address[country_id]" class="form-control">
									<? foreach ($countries as $country) : ?>
									<option value="<?php echo $country['id'];?>"  <? if ($address['country_id'] == $country['id']) echo 'selected="selected"' ?>>
									<?php echo $country['name'];?>
									</option>
									<? endforeach ?>
								</select>
							    </div>
							  </div>

						    <div class="form-group">
						    	<label for="inputEmail1" class="col-lg-4 control-label">Tel</label>
							    <div class="col-lg-6">
							      <input type="input" class="form-control" id="inputFirstName" name="tel">
							    </div>
						    </div>

						    <div class="form-group">
						    	<label for="inputEmail1" class="col-lg-4 control-label">Email</label>
							    <div class="col-lg-6">
							      <input type="email" class="form-control" id="inputFirstName" name="email">
							    </div>
						    </div>

						    <div class="form-group">
						    	<label for="inputEmail1" class="col-lg-4 control-label">Confirm Email</label>
							    <div class="col-lg-6">
							      <input type="email" class="form-control" id="inputFirstName" name="email2">
							    </div>
						    </div>


						    <legend><span>Account Details</span></legend>

						    	<div class="form-group">
						    	<label for="inputEmail1" class="col-lg-4 control-label">Company Name</label>
							    <div class="col-lg-6">
							      <input type="input" class="form-control" id="inputFirstName" name="company_name">
							    </div>
						    </div>

						    <div class="form-group">
						    	<label for="inputEmail1" class="col-lg-4 control-label">Job Title</label>
							    <div class="col-lg-6">
							      <input type="input" class="form-control" id="jobTitle" name="job_title">
							    </div>
						    </div>

						    <div class="form-group">
							  	
								<label for="inputEmail1" class="col-lg-4 control-label">Business Type</label>
								<div class="col-lg-3">
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

						    <div class="form-group">
						    	<label for="inputEmail1" class="col-lg-4 control-label">Password</label>
							    <div class="col-lg-6">
							      <input type="password" class="form-control" id="inputFirstName" name="password">
							    </div>
						    </div>
						    <div class="form-group">
						    	<label for="inputEmail1" class="col-lg-4 control-label">Confirm Password</label>
							    <div class="col-lg-6">
							      <input type="password" class="form-control" id="inputFirstName" name="password2">
							    </div>
						    </div>

						    <div class="form-group">
							    <div class="col-lg-10">
							     <input type="checkbox" name="agree_to_terms" style="margin:-5px 10px 0 0;">I agree to Clock In Point's <a href="#">Terms of Services</a> and <a href="#">Privacy Policy</a>.
							    </div>
						    </div>

						    <input type="submit" value="Continue" class="btn btn-primary"/>
	          	</form>
	        </div>