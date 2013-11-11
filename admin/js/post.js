$(document).ready(function() { 
  $('.error').hide();
  

  $("#submit_btn").submit(function() {
		// validate and process form
		// first hide any error messages
    $('.error').hide();
		
	  var name = $("input#first_name").val();
		if (name == "") {
	      $("label#first_name_error").show();
	      $("input#first_name").focus();
	      return false;
		}
		

      var dataString = 'first_name='+ name + '&username=' + username + '&password=' + password + '&generic_content=' + generic_content;
		
		//alert (dataString);return false;
		
	  var baseUrl = '<?php echo site_url(); ?>';
	
	  $.ajax({
      type: "POST",
      url: baseUrl + "clients/account_create/",
      data: dataString,
      success: function() {
        $('#contact_form').html("<div class='success'></div>");
        $('.success').html("<h2>Success!</h2>")
        .append("<p>You account has been successfully created, please check your email to confirm.</p>")
        .hide()
        .fadeIn(1500, function() {
          $('#message').append("<img id='checkmark' src='../images/check.png' />");
        });
      }
     });
    return false;
	});
});