<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="description" content="Clock In Point | meta description goes here" />
<title>Clock In Point</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
<!-- Stylesheets -->
<link href="css/bootstrap.css" rel="stylesheet" media="screen">
<link href="css/responsive.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />
<!--[if IE 6]>
  <link rel="stylesheet" type="text/css" href="css/ie6.css" />
<![endif]-->
<!-- Javascript, jQuery -->
<script src="js/respond.src.js"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.lightbox-0.5.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript">
 // DOM ready
 $(function() {
      // To make dropdown actually work
      $("nav select").change(function() {
        window.location = $(this).find("option:selected").val();
      });

      $('a.enlarge').lightBox();
 });
</script>
<!--
<script type="text/javascript">
$(function() {
    $('a.enlarge').lightBox();
});
</script>
-->
</head>
<body>
	<div class="container">
		<?php include 'includes/header.php'; ?>
      <div class="clearfix"></div>
    	    <div class="row subheader">
              	<div class="span8 subheader">
              		<img src="img/feature-image-internal.gif" width="100%" max-width="100%" height="291" class="feature">
                    <div class="internal-content">
                        <h1>How it works</h1>
                        <h2>Unique Encrypted Code Which Changes Every 60 Seconds</h2>
                        <p>Installed ClockinPoint units automatically generate a unique encrypted 8 digit code which changes every 60 seconds to support accurate and indisputable timekeeping.  These codes represent a unique identifier linking a sole user to a specific site, on a specific date and at a ‘to the minute’ time, which can only be verified online within approved ClockinPoint accounts.  Upon arrival and departure at a site, or as a single time stamp, the user pushes the button on the device to record the code displayed on the unit. The user could be an employee, a service provider, a contractor or any other application where recording of accurate timekeeping is important or maybe, crucial.</p>
                      <h2>Upload Into Online Account</h2>
                        <p>Once codes have been generated and recorded they can be utilised in two ways.  It is recommended that the user uploads the codes into the Service Provider section of the clients’ online account, via our ClockinPoint App or PC.</p>
                        <h2>Generate ClockinPoint Verified Statement</h2>
                        <p>A ClockinPoint verified statement can then be generated and submitted with invoice or checked online by the client, using the unique report identifier reference.  Alternatively, codes can be entered on invoices or timesheet records for reference. They can be randomly checked by the client or audited whenever necessary.</p>
                      <h2>7 Year Audit Trail &amp; Reports</h2>
                        <p>All codes can be entered and checked up to 7 years from the time of generation, enabling verification of attendance at the location.  Activity reports can be produced using a wide range of standard and customized parameters.</p>
                        <h2>Out of the Box Solution</h2>
                        <p>ClockinPoint is an 'Out of the box' solution. Once you receive your ClockinPoint device, simply create an account online and register it with us. Registration could not be easier- hold the device to your computer screen and watch your screen upload the program information in seconds. Installation is two AA batteries and two tamperproof screws. (Removable screws can be used if desired.) Once installed, the unit cannot be removed without damage and detection. You’re ready to go!</p>                    
                    
                    </div>
                </div>
                <div class="pull-right">
              	   <?php include 'includes/login-panel.php';?>
                   <br />
                   <a class="enlarge" href="img/timesheet-large.jpg" title=""><img src="img/timesheet.jpg" width="375" height="216" alt=""></a><br /><br />
                  <img src="img/monitor.jpg" width="375" height="258" alt="">          
                </div>
    		  </div>

          <div class="row">
              <div class="span12">

              </div>
                  
          </div>

        <?php include 'includes/device.php'; ?> 

	</div>
</body>
</html>