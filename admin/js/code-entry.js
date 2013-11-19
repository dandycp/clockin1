$(function() {
						   
	// add button action
	$(".codes-container").on('click','.add-btn', function (e) {
		e.preventDefault();
		add_row($(this));
	});
	
	// delete button action
	$(".codes-container").on('click','.delete-btn', function (e) {
		e.preventDefault();
		delete_row($(this).closest('.row'));
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
		if ($this.val().length == 8) validate_field($this);
	});
	
	// auto-tabbing and row creation for single and end codes
	$(".codes-container").on('keyup', '.single-code, .end-code', function(e) {
		// add a new row if this is the last row
		var char_count = $(this).val().length;
		$this_row = $(this).closest('.row');
		if (char_count == 8 && input_character(e)) {
			if ($this_row.is(':last-child')) {
				// add a new row
				add_row($(this));
			} else {
				// tab to the next one
				$this_row.closest('.codes-container').find('.row:last-child input:eq(0)').focus();
			}
		}
	});
	
	// auto-tabbing for start codes
	$(".codes-container").on('keyup', '.start-code', function(e) {
		// move to the end code
		var char_count = $(this).val().length;
		if (char_count == 8 && input_character(e)) {
			$this_row = $(this).closest('.row');
			$this_row.find('.end-code').focus();
		}
	});
	
	// change clients
	$("#client_id").change(function(e) {
		update_client_categories();								
	});
	
	// default values
	$("#default_category_id").change(function(e) {
		var $next_empty_row = $(".code:text[value='']").closest('.row');
		if ($next_empty_row) $next_empty_row.find(".category_id").val($(this).val());
	});
	$("#default_person_id").change(function(e) {
		var $next_empty_row = $(".code:text[value='']").closest('.row');
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
	var num_rows = $container.find(".row").size();
	var $old_row = $container.find(".row").eq(num_rows-1);
	var $new_row = $old_row.clone();
	$new_row.appendTo($container);
	
	$container.find(".row").each(function(index){
		$(this).find('input,select').each(function(){
			var new_name = $(this).attr("name").replace(/\[\d+\]/,"["+index+"]");
			$(this).attr("name", new_name);
		});
	});
	
	$new_row.find("input").val('').eq(0).focus();
	$old_row.find(".add-btn").hide();
	$new_row.find(".add-btn, .delete-btn").show();
	
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
	var $last_row = $container.find(".row:last-child");
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
    var $row = $field.closest('.row');
    var selector = '.help-block.'+type;
    var $helpBlock = $control_group.find(selector);

	// check they've actually selected a client, if appropriate
	if ($("#client_id").size() && $("#client_id").val() == '') {
		alert('A client must be selected');
	}
	// if a client has been selected, pass this as the user_id
	var user_id = $("#client_id option:selected").size() ? $("#client_id option:selected").val() : '' ;
	//console.log('doing validation ' + code);


	if ($field.data('request') != null) $field.data('request').abort();
	$helpBlock.html('');
	var request = $.getJSON('codes/validate/' + code + '/' + user_id, function(data) {
		if (data.valid) {
			$control_group.addClass('success');
			$control_group.removeClass('error');
			$helpBlock.html(data.device.name + ' - ' + data.reason);
			$field.data('device', data.device);
			// if this is an 'end' code, prompt the user, if their start code was for a different device
			if (type == 'end') {
				$start_code = $row.find('.start-code');
				if ($start_code.data('device').id != data.device.id) 
					alert('Notice: End code is for a different device');
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