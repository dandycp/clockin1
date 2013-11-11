<h1>Change Package</h1>

<? if ($error) : ?>
<div class="alert alert-error"><strong>Error: </strong><?=$error?></div>
<? endif ?>
    
<form id="change-package-form" action="<?php echo site_url(); ?>clients/account/change_package" class="form-inline" role="form" method="post">

<fieldset>

<legend><span>Account Package</span></legend>


<div class="control-group">
	
	<label class="control-label">Account Type</label>
	
	<div class="controls">
		<label class="radio inline">
		<input type="radio" name="type" value="basic" <?=$account->type == 'basic' ? 'checked="checked"' : '' ?> />
		<strong>Basic</strong>
		</label>
		
		<label class="radio inline">
		<input type="radio" name="type" value="pro" <?=$account->type == 'pro' ? 'checked="checked"' : '' ?> />
		<strong>Pro</strong>
		</label>
	</div>
</div>


<div class="form-group">
    <label for="exampleInputEmail2">Device Limit</label>
    <input type="text" name="device_limit" class="form-control" value="<?=$account->device_limit?>">
  </div>

</fieldset>
<br />

<div class="well">
<strong>Subscription Cost (Annual): </strong>&pound;<span id="package_cost"><?=$account->subscription()->amount?></span>
</div>

<div class="form-actions">
<button type="submit" class="btn btn-success btn-large">Change Package</button>
</div>

</form>

<script>

function check_price($form)
{
	var values = $form.serialize();
	get_price(values);
}

function get_price(values)
{
	$.getJSON('subscription/get_price', values, display_price);
}

function display_price(data)
{
	if (data.valid) {
		$("#package_cost").text(parseFloat(data.price).toFixed(2));
	} else {
		$("#package_cost").html('<span class="label-warning">' + data.message + '</span>');
	}
}

$(function() {
	var $form = $("#change-package-form");
	check_price($form);
	$form.find('input').bind('change keyup', function() { check_price($form); });
	
});
</script>
