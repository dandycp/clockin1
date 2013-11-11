<!DOCTYPE html>
<html lang="en">
<head>
<title>Clock In Point - <?php echo $title; ?></title>
<!--
<meta name="description" content="<?php echo $meta_desc; ?>" />
<meta name="keywords" content="<?php echo $meta_keys; ?>" />
-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Stylesheets -->
<link href="<?php echo site_url();?>css/bootstrap.css" rel="stylesheet" media="screen">
<link href="<?php echo site_url();?>css/styles.css" rel="stylesheet" media="screen">
<link href="<?php echo site_url();?>css/responsive.css" rel="stylesheet" media="screen">
<link rel="stylesheet" type="text/css" href="<?php echo site_url();?>css/jquery.lightbox-0.5.css" media="screen" />
<!--[if IE 6]>
  <link rel="stylesheet" type="text/css" href="css/ie6.css" />
<![endif]-->
<!--[if lt IE 7]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE7.js"></script>
<![endif]-->
<!-- Javascript, jQuery -->
<script src="<?php echo site_url();?>js/respond.src.js"></script>
<script type="text/javascript" src="<?php echo site_url();?>js/flow.js"></script>
<script src="<?php echo site_url();?>js/jquery-latest.js"></script>
<script src="<?php echo site_url();?>js/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo site_url();?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo site_url();?>js/jquery.lightbox-0.5.js"></script>
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script> -->
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
<script>
    $(document).ready(function(){

    $(".panel-red").click(function(){
         window.location=$(this).find("a").attr("href"); 
         return false;
    });
    $(".panel-black").click(function(){
         window.location=$(this).find("a").attr("href"); 
         return false;
    });
    $(".panel-grey").click(function(){
         window.location=$(this).find("a").attr("href"); 
         return false;
    });

    });
    </script>
</head>
<body>
  <?php if ($this->agent->is_mobile()) { ?>
     <!-- Static navbar -->

      <div class="navbar navbar-default navbar-static-top">
        <div class="container">
        <a class="navbar-brand" href="<?php echo site_url(); ?>"></a>
        

        <div class="navbar-header" style="padding: 5px;">

          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span style="padding: 11px;">Menu</span>
          </button>
          
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li <?php if ($this->uri->segment(1) == 'home' || $this->uri->segment(1) == '') { echo 'class="active"'; } else {} ?>><a href="home">Home</a></li>  
            <li <?php if ($this->uri->segment(1) == 'howitworks') { echo 'class="active"'; } else {} ?>><a href="howitworks">How it Works</a></li>
            <li <?php if ($this->uri->segment(1) == 'benefits') { echo 'class="active"'; }else {} ?>><a href="benefits">Benefits</a></li>
            <li <?php if ($this->uri->segment(1) == 'applications') { echo 'class="active"'; }else {} ?>><a href="applications">Applications</a></li>
            <li <?php if ($this->uri->segment(1) == 'wheretobuy') { echo 'class="active"'; }else {} ?>><a href="wheretobuy">Where to Buy</a></li>
            <li <?php if ($this->uri->segment(1) == 'partners') { echo 'class="active"'; }else {} ?>><a href="partners">Partners Area</a></li>
            <li <?php if ($this->uri->segment(1) == 'contact') { echo 'class="active"'; }else {} ?>><a href="contact">Contact Us</a></li>
            
          </ul>
        </div><!--/.nav-collapse -->
      </div>
      </div>
   
  <div style="margin-bottom: 10px;"></div>
          <div class="container">

  <?php }
    else { ?>
     <!-- Static navbar -->
 <div class="header-tops">
     <div class="container">
      <div class="navbar navbar-default navbar-static-top">
        <div class="container">
        <a class="navbar-brand" href="<?php echo site_url(); ?>"></a>
        

        <div class="navbar-header">

          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li <?php if ($this->uri->segment(1) == 'home' || $this->uri->segment(1) == '') { echo 'class="active"'; } else {} ?>><a href="home">Home</a></li>  
            <li <?php if ($this->uri->segment(1) == 'howitworks') { echo 'class="active"'; } else {} ?>><a href="howitworks">How it Works</a></li>
            <li <?php if ($this->uri->segment(1) == 'benefits') { echo 'class="active"'; }else {} ?>><a href="benefits">Benefits</a></li>
            <li <?php if ($this->uri->segment(1) == 'applications') { echo 'class="active"'; }else {} ?>><a href="applications">Applications</a></li>
            <li <?php if ($this->uri->segment(1) == 'wheretobuy') { echo 'class="active"'; }else {} ?>><a href="wheretobuy">Where to Buy</a></li>
            <li <?php if ($this->uri->segment(1) == 'partners') { echo 'class="active"'; }else {} ?>><a href="partners">Partners Area</a></li>
            <li <?php if ($this->uri->segment(1) == 'contact') { echo 'class="active"'; }else {} ?>><a href="contact">Contact Us</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
      </div>
    </div>
  </div>
  <div style="margin-bottom: 10px;"></div>
          <div class="container">
            <?php }?>
            <!-- /Content -->

            <?php echo $content; ?>

            <!-- /end content -->

  <?php if ($this->agent->is_mobile()) { ?>
        <div class="row pull-left">
        <div class="col-md-4 panel panel-first panel-red"><h2>Public Sector</h2><p>Multiple applications in providing<br />evidence of attendance, <br />eliminating
            invoicing fraud and <br />overpayments. <a href="applications">View more &raquo;</a></p></div>
        <div class="col-md-4 panel panel-black"><h2>Business Use</h2><p>Log the attendance of <br />sub-contract, flexitime, <br />full/part-time and freelance workers.<br />Generate online record sheets. <a href="applications">View more &raquo;</a></p></div>
        <div class="col-md-4 panel panel-grey"><h2>Home Use</h2><p>A simple and mutually reassuring<br />system for recording the <br />attendance hours of <br />domestic staff and trade workers. <a href="applications">View more &raquo;</a></p></div>
    </div>
    <?php } else { ?>

    <?php if ($this->uri->segment(1) == 'contact' || $this->uri->segment(1) == 'partners' || $this->uri->segment(1) == 'partners_area')  { echo ''; } else { ?>
    <div class="row pull-left">
        <div class="col-md-4 panel panel-first panel-red"><h2>Public Sector</h2><p>Multiple applications in providing<br />evidence of attendance, <br />eliminating
            invoicing fraud and overpayments. <a href="applications">View more &raquo;</a></p></div>
        <div class="col-md-4 panel panel-black"><h2>Business Use</h2><p>Log the attendance of <br />sub-contract, flexitime, <br />full/part-time and freelance workers.  Generate online record sheets. <a href="applications">View more &raquo;</a></p></div>
        <div class="col-md-4 panel panel-grey"><h2>Home Use</h2><p>A simple and mutually reassuring<br />system for recording the <br />attendance hours of domestic staff and trade workers. <br /><a href="applications">View more &raquo;</a></p></div>
    </div>
    
      
    <?php } }?>

  <div class="footer">
        <p>&copy; <?php echo date('Y'); ?> ClockinPoint&trade;<br />
        All rights reserved.</p>
      </div>

    </div> <!-- /container -->
    <!-- Analytics -->
    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-36559933-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>
  </body>
</html>