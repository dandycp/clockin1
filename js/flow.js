$(function() {
  $('.error').hide();
  

  $(".button").click(function() {
    // validate and process form
    // first hide any error messages
    $('.error').hide();
    
    var name = $("input#name").val();
    if (name == "") {
      $("label#name_error").show();
      $("input#name").focus();
      return false;
    }
    var username = $("input#username").val();
    if (username == "") {
      $("label#username_error").show();
      $("input#username").focus();
      return false;
    }
    var password = $("input#password").val();
    if (password == "") {
      $("label#password_error").show();
      $("input#password").focus();
      return false;
    }

    var generic_content = $("select#generic_content").val();
    if (generic_content == "") {
        $("label#generic_content_error").show();
        $("select#generic_content").focus();
        return false;
    }
    
    //var dataString = 'name='+ name ;
    var dataString = 'name='+ name + '&username=' + username + '&password=' + password + '&generic_content=' + generic_content;
    
    //alert (dataString);return false;
    
    var baseUrl = '<?php echo base_url(); ?>';
  
    $.ajax({
      type: "POST",
      url: baseUrl + "admin/insertm/",
      data: dataString,
      success: function() {
        $('#contact_form').html("<div class='success'></div>");
        $('.success').html("<h2>Success!</h2>")
        .append("<p>The member has been successfully stored in the database.</p>")
        .hide()
        .fadeIn(1500, function() {
          $('#message').append("<img id='checkmark' src='../images/check.png' />");
        });
      }
     });
    return false;
  });
});
