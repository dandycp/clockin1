<? 
require 'includes/Database.php';
$db = new Database();
$distributors = $db->get_all('distributor', "ORDER BY RAND()");
?>
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
                        <h1>Where to Buy</h1>
                        <p>ClockinPoint has a national network of distributors and resellers.  Please see the list below or email <a href="mailto:sales@clockinpoint.com">sales@clockinpoint.com</a> in the first instance, to be directed to the most suitable contact in the channel for your needs.</p>

                        <div class="div-list">
                        <? foreach ($distributors as $d) : ?>
                        <div>
                        
                        <? if (!empty($d['logo'])) : ?>
                        <img src="userfiles/distributors/logos/<?=$d['logo']?>" width="120" class="logo" />
                        <? endif ?>
                        
                        <h3><?=$d['name']?></h3>
                        
                        <dl>
                        
                        <? if (!empty($d['tel'])) : ?>
                        <dt>Tel</dt>
                        <dd><?=$d['tel']?></dd>
                        <? endif ?>
                        
                        <? if (!empty($d['website'])) : ?>
                        <dt>Web</dt>
                        <dd><a href="http://<?=$d['website']?>"><?=$d['website']?></a></dd>
                        <? endif ?>
                        
                        <? if (!empty($d['address'])) : ?>
                        <dt>Address</dt>
                        <dd><?=nl2br($d['address'])?>, <?=$d['postcode']?></dd>
                        <? endif ?>
                        
                        </dl>
                        
                        </div>
                        <? endforeach ?>
                        </div>

                      <p>If you are interested in becoming a distributor or reseller, please contact National Sales Manager, Helen McCourty on 07791 670 602 or email <a href="mailto:helen.mccourty@clockinpoint.com">helen.mccourty@clockinpoint.com</a>.</p>
                                      
                    
                    </div>
                </div>
                <div class="pull-right">
              	   <?php include 'includes/login-panel.php';?>         
                </div>
    		  </div>

          <div class="row">
              <div class="span12">
                  
          </div>

        <?php include 'includes/device.php'; ?> 

	</div>
</body>
</html>