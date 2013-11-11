// validate a particular input field
function validate($field) 
{
	replace_incorrect_characters($field);
	
	var code = $field.val();	

	var $control_group = $field.closest('.form-group');
	var $row = $field.closest('.row');
	if ($field.data('request') != null) $field.data('request').abort();
	$control_group.find('.help-block').html('');
	$request = $.getJSON('devices/validate/' + code + '/' + user_id, function(data) {
		console.log($request);
		if (data.valid) {
			$control_group.addClass('success');
			$control_group.removeClass('error');
			$row.find('.help-block').html(data.device.name + ' - ' + data.reason);
			$field.data('code', data.single);
			//if this is an 'end' code, prompt the user, if their start code was for a different device
			
		} else {
			$control_group.addClass('error');
			$control_group.removeClass('success');
			//var msg = data.reason;
			msg = msg + 'Wrong code';
			$row.find('.help-block').html(msg);
		}
	});
	$field.data('request', request);
}