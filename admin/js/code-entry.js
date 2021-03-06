$(function() {
						   
	// add button action
	$(".codes-container").on('click','.add-btn', function (e) {
		e.preventDefault();
		add_row($(this));
	});
	
	// delete button action
	$(".codes-container").on('click','.delete-btn', function (e) {
		e.preventDefault();
		delete_row($(this).closest('.code-row'));
	});
	
	// only allow input of valid characters
	$(".codes-container").on('keydown', '.code', function(e) {
		if (!allowed_character(e)) {
			e.preventDefault();
			e.stopPropagation();
		}
	});
	
	$(".codes-container").on('keyup', '.code', function(e) {
		var $this = $(this);
		if ($this.val().length == 8) {
			validate_field($this);
		}
	});
	
	// auto-tabbing for start codes
	$(".codes-container").on('keyup', '.start-code', function(e) {
		// move to the end code
		var char_count = $(this).val().length;
		if (char_count == 8 && input_character(e)) {
			$this_row = $(this).closest('.code-row');
			$this_row.find('.end-code').focus();
		}
	});
	
	// change clients
	$("#client_id").change(function(e) {
		update_client_categories();								
	});
	
	// default values
	$("#default_category_id").change(function(e) {
		var $next_empty_row = $(".code:text[value='']").closest('.code-row');
		if ($next_empty_row) $next_empty_row.find(".category_id").val($(this).val());
	});
	$("#default_person_id").change(function(e) {
		var $next_empty_row = $(".code:text[value='']").closest('.code-row');
		if ($next_empty_row) $next_empty_row.find(".person_id").val($(this).val());
	});
	$("#default_provider_id").change(function(e) {
		var $next_empty_row = $(".code:text[value='']");
		if ($next_empty_row) $next_empty_row.find(".provider_id").val($(this).val());
	});
});

function update_client_categories()
{
	var client_id = $("#client_id").val();
	clear_categories();
	$.getJSON('categories/get/' + client_id, function(data) {
		populate_categories(data);
	});
}

function clear_categories()
{
	populate_categories({});	
}

function populate_categories(data)
{
	var option_list = [];
	var $option = $("<option>").val('').text(' - ');
	option_list.push($option);
	
	for (var i in data) {
		$option = $("<option>").val(data[i].id).text(data[i].name);	
		option_list.push($option);
	}
	
	$(".category_id").empty();
	$(".category_id").append(option_list);
	
}

function add_row($trigger_element) 
{
	var $container = $trigger_element.closest('.codes-container');
	var num_rows = $container.find(".code-row").size();
	var $old_row = $container.find(".code-row").eq(num_rows-1);
	var $new_row = $old_row.clone();
    $new_row.appendTo($container);

	
	$container.find(".code-row").each(function(index){
		$(this).find('input,select').each(function(){
			var new_name = $(this).attr("name").replace(/\[\d+\]/,"["+index+"]");
			$(this).attr("name", new_name);
		});
	});
	
	$new_row.find("input").val('').eq(0).focus();
	$old_row.find(".add-btn").hide();
	$new_row.find(".add-btn, .delete-btn").show();
    $new_row.find(".help-block").html('');
    $new_row.find('.duration').html('');
	
	// set default values where applicable
	var category_id = $("#default_category_id").val();
	var person_id = $("#default_person_id").val();
	if (category_id) $new_row.find(".category_id").val(category_id);
	if (person_id) $new_row.find(".person_id").val(person_id);
}

function delete_row($row)
{
	var $container = $row.closest('.codes-container');
	$row.remove();
	var $last_row = $container.find(".code-row:last-child");
	$last_row.find(".add-btn").show();
}

// check only a-z and 0-9 and delete and backspace allowed
function allowed_character(e) 
{
	if (e.shiftKey) return false;
	var keyCode = e.keyCode;
	if (keyCode >= 48 && keyCode <= 57) return true;
	if (keyCode >= 65 && keyCode <= 90) return true;
	if (keyCode >= 96 && keyCode <= 105) return true;
	if (keyCode == 8) return true; // backspace
	if (keyCode == 46) return true; // delete
	if (keyCode == 37) return true; // left
	if (keyCode == 39) return true; // right
	return false;
}

// check only a-z and 0-9 allowed
function input_character(e) 
{
	if (e.shiftKey) return false;
	var keyCode = e.keyCode;
	if (keyCode >= 48 && keyCode <= 57) return true;
	if (keyCode >= 65 && keyCode <= 90) return true;
	if (keyCode >= 96 && keyCode <= 105) return true;
	return false;
}

function replace_incorrect_characters($field)
{
	var mappings = { 'D':'0', 'I':'1', 'L':'1', 'O':'0' };
	var code = $field.val().toUpperCase();
	
	for (var i in mappings) {
		var pattern = new RegExp(i, "g");
		code = code.replace(pattern, mappings[i]);
	}
	$field.val(code);
}

// validate a particular input field
function validate_field($field) 
{
	replace_incorrect_characters($field);

	var code = $field.val();
    var type = $field.hasClass('end-code') ? 'end' : 'start' ;
    var $control_group = $field.closest('.control-group');
    var $row = $field.closest('.code-row');
    var selector = '.help-block.' + type;
    var $helpBlock = $row.find(selector);

	// check they've actually selected a client, if appropriate
	if ($("#client_id").size() && $("#client_id").val() == '') {
		alert('A client must be selected');
	}
	// if a client has been selected, pass this as the user_id
	var user_id = $("#client_id option:selected").size() ? $("#client_id option:selected").val() : '' ;
	//console.log('doing validation ' + code);


	if ($field.data('request') != null) $field.data('request').abort();
	$helpBlock.html('');
    $field.data('timestamp', null);
	var request = $.getJSON(site_url + 'codes/validate/' + code + '/' + user_id, function(data) {
		if (data.valid) {
			$control_group.addClass('success');
			$control_group.removeClass('error');
			$helpBlock.html(data.device.name + ' - ' + data.reason);
			$field.data('device', data.device);
            $field.data('timestamp', data.timestamp);
			// if this is an 'end' code, prompt the user, if their start code was for a different device
			if (type == 'end') {
				$start_code = $row.find('.start-code');
				if ($start_code.data('device').id != data.device.id) 
					alert('Notice: End code is for a different device');
                // calculate the duration between the start and end codes
                $start_time = $start_code.data('timestamp');
                $end_time = $field.data('timestamp');
                var duration = $end_time - $start_time;
                var hours = Math.floor(duration / 3600);
                var minutes = Math.round((duration - (hours * 3660)) / 60);
                var durationText = hours + 'h, ' + minutes + 'm';
                $row.find('.duration').html('Duration: ' + durationText);
			}
		} else {
			$control_group.addClass('error');
			$control_group.removeClass('success');
			var msg = data.reason;
			msg = msg + ' - try our <a target="_blank" href="codes/finder">Near Miss Finder</a>';
			$helpBlock.html(msg);
		}
	});
	$field.data('request', request);
}