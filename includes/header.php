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
        <div class="row"><div class="span12 header"><a href="/" class="logo"><span>Clock In Point</span></a></div></div>

        <?
            //$currentFile = $_SERVER["PHP_SELF"];
            //$parts = Explode('/', $currentFile);
            //$pagename = $parts[count($parts) - 1];

        ?>

    <div class="navbar">
        <div class="navbar-inner">     
            <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span style="color: #000; margin: 0 auto; width: 100%;">Show Menu</span>
            </a>
     
            <!-- Everything you want hidden at 940px or less, place within here -->
            <div class="nav-collapse collapse">
            <!-- .nav, .navbar-search, .navbar-form, etc -->
              <ul class="nav">
                <li><a href="index.php">Home</a></li>  
                <li><a href="howitworks.php">How it Works</a></li>
                <li><a href="benefits.php">Benefits</a></li>
                <li><a href="applications.php">Applications</a></li>
                <li><a href="wheretobuy.php">Where to Buy</a></li>
                <li><a href="contact.php">Contact Us</a></li>
              </ul>
            </div>
     
          
        </div>
      </div>
      <div class="clearfix"></div>
            <div class="row subheader">
                <div class="span8 subheader">
                    <img src="img/feature-image.gif" width="100%" max-width="100%" height="291" class="feature">
                </div>
                <div class="pull-right">
                   <?php $this->load->view('includes/login-panel');?>                
                </div>
              </div>