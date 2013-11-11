<!DOCTYPE html>
<html lang="en">
<head>
<meta name="description" content="Clock In Point | meta description goes here" />
<title>Clock In Point - Welcome</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
<!-- Stylesheets -->
<link href="css/bootstrap.css" rel="stylesheet" media="screen">
<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />
<!--[if IE 6]>
  <link rel="stylesheet" type="text/css" href="css/ie6.css" />
<![endif]-->
<!--[if lt IE 7]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE7.js"></script>
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

      $('.row div[class^="span"]:last-child').addClass('last-child');
 });
</script>
</head>
<body>
<div class="container">

 <div class="row">
              <div class="span12">
                  <div class="padding"><h1>The most cost effective time &amp; attendance system available  –  <span class="red-text">at the touch of a button...</span></h1>
                    <p class="front">ClockinPoint is an innovative, low cost attendance validation system which can be used to monitor contractual time, ensure accuracy of account payments, detect under or over performance, reveal absence and lateness, identify anomalies and provide supporting evidence.</p>
                    
                </div>
          </div>
</div><!-- End container -->
</body>
</html>