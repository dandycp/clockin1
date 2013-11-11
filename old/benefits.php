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
                        <h1>Benefits</h1>
                        <ul class="bullet-list">
                          <li>exceptionally low cost – ROI within 1-3 months for every client</li>
                            <li>no internet connectivity required</li>
                            <li>no power connection required</li>
                            <li>quick and easy to install and set up</li>
                            <li>tamperproof and waterproof – for indoor and outdoor use</li>
                            <li>stylish, discreet and hygienic</li>
                            <li>up to 5 year battery life (2 x AA) – battery low email alert</li>
                            <li>verify accurate, to the minute, arrival and departure times or single time stamps</li>
                            <li>ensure suppliers and contractors billing by the hour are actually in attendance for hours invoiced</li>
                            <li>eliminate fraudulent invoicing and staff/contractor overpayments – eg <em>overpayment of just 1 hour a week at the National Minimum Wage equals £321.88 per annum</em></li>
                        </ul>
                        <ul class="bullet-list">
                          <li>manage asset servicing schedules</li>
                            <li>monitor unauthorised, unusual or potentially fraudulent activity with alerts</li>
                            <li>fully customised restriction and alert rules</li>
                            <li>automatic statement and invoice generation, for client or service provider, verified by ClockinPoint</li>
                            <li>7 year online audit trail</li>
                            <li>management of multiple site activity from a central point</li>
                            <li>reduced administration; no biometric enrolment necessary</li>
                            <li>accountability sits with the supplier, control sits with the client</li>
                            <li>high level cryptography</li>
                            <li>patented technology</li>
                        </ul>
                    </div>
                </div>
                <div class="pull-right">
              	   <?php include 'includes/login-panel.php';?>
                   <br />
                   <img src="img/wall-device.jpg" width="375" height="228" alt="">          
                </div>
    		  </div>

          <div class="row">
              <div class="span12">
                  
          </div>

        <?php include 'includes/device.php'; ?> 

	</div>
</body>
</html>