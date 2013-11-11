<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Clock In Point - <?php if ($this->uri->segment(2) == 'approve') { echo 'Provider Approved'; } else { echo $title; } ?></title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="base" content="<?php echo site_url(); ?>">

<!-- stylesheets -->
<link rel="stylesheet" href="<?php echo site_url(); ?>css/bootstrap3.css">
<link rel="stylesheet" href="<?php echo site_url(); ?>css/client.css">
<link rel="stylesheet" href="<?php echo site_url(); ?>css/blitzer/jquery-ui-1.10.3.custom.css" />
<link rel="stylesheet" href="<?php echo site_url(); ?>css/entry.css" />
<link rel="stylesheet" href="<?php echo site_url(); ?>css/invoice.css" />
<!-- javascript/jQuery -->
<script src="<?php echo site_url(); ?>js/post.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>js/bootstrap3.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>js/jquery-10.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>js/jquery-ui.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>js/bootstrap.js" type="text/javascript"></script>

<script src="<?php echo site_url(); ?>js/device-registration.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>js/timepicker.js"></script>

<script src="<?php echo site_url(); ?>js/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo site_url(); ?>js/datatables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo site_url(); ?>js/datatables/extras/ColVis/media/js/ColVis.min.js"></script>
<script src="<?php echo site_url(); ?>js/reports.js"></script>
<script src="<?php echo site_url(); ?>js/parsley.js"></script>
<link rel="stylesheet" href="<?php echo site_url(); ?>js/datatables/extras/TableTools/media/css/TableTools.css" />
<link rel="stylesheet" href="<?php echo site_url(); ?>js/datatables/extras/ColVis/media/css/ColVis.css" />
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.js"></script>
<![endif]-->
<script type="text/javascript">
$(function(){
  // change page to ajax_page in pagination urls
  $('#pagination a').each(function(){
    var href = $(this).attr('href');
    href = href.replace(/page/,'ajax_page');
    $(this).attr('href',href);
  });
  // ajax request
  $('#pagination a').click(function(){
    $.ajax({
       type: "GET",
       url: $(this).attr('href'),
       success: function(table){
          $('table').remove(); // remove content
          $('#pagination').after(table); // add content
       }
    });

    return false; // don't let the link reload the page
  });
});

</script>
<script type="text/javascript">
$(document).ready(function() { 
    // onclick of download button
    $("#download").click(function(){
      // Set a timeout of 5 secs then show step2
      window.setTimeout(function () { $('#step2').show(); }, 5000); 
      $("#download_area").hide();
    });    

    $("#otherbtn").click(function(){
      $("step2").show();
      $("download_area").hide();
    });   
});
</script>
<script type="text/javascript">
$(document).ready(function() {
  $("#user-input").hide();
  $("#group-device").click(function(e) { e.preventDefault(); $("#user-input").toggle(); });
  $("#no-show").click(function(e) {e.preventDefault(); $("#groups").hide(); });

  $("#new-address").hide();
  $("#reallocate").click(function(e) { e.preventDefault(); $("#new-address").toggle(); });
});
</script>
<script type="text/javascript">
  $(document).ready(function() { 
  	
  	$('a').tooltip();

  	
    // Code to swap between the two(2) divs show/hide
    $("#do").click(function(){
      $('#device-owner').show();
          //$("#sp").hide()
      });

    $("#sp").click(function(){
      $('#service-provider').show();
         // $("#do").hide()
      });

          
    var dragItems = document.querySelectorAll('[draggable=true]');

    for (var i = 0; i < dragItems.length; i++) {
      addEvent(dragItems[i], 'dragstart', function (event) {
        // store the ID of the element, and collect it on the drop later on

        event.dataTransfer.setData('Text', this.id);
      });
    }
  });
</script>

</head>
<body>
   <!-- Static navbar -->
 <div class="header-tops">
     <div class="container">
    <div class="navbar navbar-default navbar-static-top" role="navigation" style="border: none;">
        <div class="navbar-header">

          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

          <a class="navbar-brand" href="/" data-toggle="tooltip" title="Website Home Page" data-placement="bottom"></a>
        </div>
        <?php if ($this->session->userdata('is_logged_in') === true) : ?>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li <? if (strpos(uri_string(),'clients/codes')===0) echo 'class="active"'?>><a href="<?php echo site_url(); ?>clients/codes" data-toggle="tooltip" data-placement="bottom" data-original-title="Enter your Clockin Point codes here">Enter Codes</a></li>
            
            <li <? if (strpos(uri_string(),'clients/reports')===0) echo 'class="active"'?>><a href="<?php echo site_url(); ?>clients/reports" data-toggle="tooltip" data-placement="bottom" data-original-title="View / Edit / Generate Your Reports">Reports</a></li>
					
					<? if ($this->account['show_devices'] == 0) : ?>
					<li <? if (strpos(uri_string(),'clients/devices')===0) echo 'class="active"'?>><a href="<?php echo site_url(); ?>clients/devices" data-toggle="tooltip" data-placement="bottom" data-original-title="Add / Edit Your Devices">Devices</a></li>
					<? endif ?>
					
					
					
					<? if ($this->account['type'] === 'pro') : ?>
					<li <? if (strpos(uri_string(),'clients/providers')===0) echo 'class="active"'?>><a href="<?php echo site_url(); ?>clients/providers" data-toggle="tooltip" data-placement="bottom" data-original-title="Add / Edit Provider Details">Providers</a></li>
					<? endif ?>
					
					
					
					<? if ($this->account['show_clients'] == 0) : ?>
					<li <? if (strpos(uri_string(),'clients/customers')===0) echo 'class="active"'?>><a href="<?php echo site_url(); ?>clients/customers" data-toggle="tooltip" data-placement="bottom" data-original-title="Add / Edit Your Client's Details">Clients</a></li>
				  <? endif ?>

        
          <li <? if (strpos(uri_string(),'clients/notifications')===0) echo 'class="active"'?>><a href="<?php echo site_url(); ?>clients/notifications" data-toggle="tooltip" data-placement="bottom" data-original-title="System Notifications">
            Notifications
            </a></li>

            <li <? if (strpos(uri_string(),'clients/invoices')===0) echo 'class="active"'?>><a href="<?php echo site_url(); ?>clients/invoices" data-toggle="tooltip" data-placement="bottom" data-original-title="My Invoices">
            Invoices
            </a></li>
            
          </ul>
          <ul class="nav navbar-nav navbar-right">
           	<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Options <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <? if ($this->account['type'] === 'pro') : ?>
					<li><a href="<?php echo site_url(); ?>clients/users" data-toggle="tooltip" data-placement="left" data-original-title="Add / Edit Users">Users</a></li>
					<? endif ?>

					<? if ($this->account['type'] === 'pro') : ?>
					<li><a href="<?php echo site_url(); ?>clients/categories" data-toggle="tooltip" data-placement="left" data-original-title="Add / Edit Categories">Work Description</a></li>
					<? endif ?>

					<? if ($this->account['type'] === 'pro' || $this->account['show_clients'] === 1) : ?>
					<li><a href="<?php echo site_url(); ?>clients/people" data-toggle="tooltip" data-placement="left" data-original-title="Add / Edit People">Work Staff</a></li>
					<? endif ?>
              <li><a href="<?php echo site_url(); ?>clients/account/edit" data-toggle="tooltip" data-placement="left" data-original-title="Edit Account Settings">Account Settings</a></li>
              
              <li><a href="<?php echo site_url(); ?>clients/users/edit/<?php echo $this->session->userdata('user_id'); ?>" data-toggle="tooltip" data-placement="left" data-original-title="Edit Your Details">User Details</a></li>
					
							
              </ul>
            </li>
            <li><a data-toggle="modal" href="#myModal">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
        <? endif ?>
        <?php if ($this->session->userdata('is_logged_in') === false) : ?>
          <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?php echo site_url();?>">Login</a></li>
          </ul>
        <?php endif ?>
     </div>
    </div>
</div>


    <div class="container">
      <?php 
      // If user is logged in show breadcrumb, otherwise don't
      if ($this->session->userdata('is_logged_in') === true && $this->uri->segment(2) != 'welcome') : ?>
        <ol class="breadcrumb">
          You are here:&nbsp;<?php echo set_breadcrumb(); ?>
        </ol>
      <? endif ?>