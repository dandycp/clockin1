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
                        <h1>Applications</h1>
                        <h2>Public Sector &amp; Social Housing</h2>
                        <p>Local Authorities use ClockinPoint to prevent invoicing fraud from ‘bill by hour’ suppliers, eliminate overpayments, manage asset servicing schedules, monitor activity, manage and streamline administration of contractors and remote staff working hours. Outsourced community services can be monitored for client attendance.</p>
                        <h2>Health &amp; Adult Social Care</h2>
                        <p>Single time stamp function monitors and improves quality and productivity of client care.  Full audit trail verifies client check frequency. Constant display mode ensures no direct contact with the unit is necessary; units remain sanitised. Automatically verify staff and outsourced care team time and attendance.</p>
                        <h2>HR &amp; Facilities Management</h2>
                        <p>ClockinPoint automatically authorises time sheets, monitors staff performance, reduces administration and eliminates overpayments. It enables staffing providers to improve client confidence and creates an auditable track record of service levels.</p>
                        <h2>Commercial &amp; Industrial</h2>
                        <p>Verify staff, contractor and supplier attendance at local and remote buildings, warehouses, reservoirs, unmanned premises and sites where assets are regularly serviced.</p>
                        <h2>Education</h2>
                        <p>Manage student study hours.  Alerts for inadequate or non attendance.</p>
                        <h2>Retail</h2>
                        <p>Centrally manage and monitor activity of contractors and remote staff attending multiple, geographically dispersed sites.  Eliminate overpayments to 'bill by hour' suppliers.</p>
                        <h2>Home User</h2>
                        <p>ClockinPoint Basic User allows homeowners to verify that the property maintenance service and social care providers they employ are delivering the service levels that are invoiced.</p>
                    </div>
                </div>
                <div class="pull-right">
              	   <?php include 'includes/login-panel.php';?>
                   <br />
                   <img src="img/nurse-taking-notes.jpg" width="375" height="622" alt="">           
                </div>
    		  </div>

          <div class="row">
              <div class="span12">
                  
          </div>

        <?php include 'includes/device.php'; ?> 

	</div>
</body>
</html>