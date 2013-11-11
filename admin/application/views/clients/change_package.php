<h1>Change Package</h1>

<? if ($error) : ?>
<div class="alert alert-error"><strong>Error: </strong><?=$error?></div>
<? endif ?>
    
<form id="change-package-form" action="account/change_package" class="form-horizontal span6" method="post">

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


<div class="control-group">
<label class="control-label">Device Limit:</label>
<div class="controls">
<input type="text" name="device_limit" class="input-small" value="<?=$account->device_limit?>">
</div>
</div>

</fieldset>

<div class="well">
<p><strong>Subscription Cost (Annual): </strong>£<span id="package_cost"><?=$account->subscription()->amount?></span></p>
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
