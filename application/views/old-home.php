<!DOCTYPE html>
<html lang="en">
<head>
<meta name="description" content="Clock In Point | meta description goes here" />
<title>Clock In Point - <?php echo $title; ?></title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
<!-- Stylesheets -->
<link href="css/bootstrap.css" rel="stylesheet" media="screen">
<link href="css/styles.css" rel="stylesheet" media="screen">
<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />
<!--[if IE 6]>
  <link rel="stylesheet" type="text/css" href="css/ie6.css" />
<![endif]-->
<!--[if lt IE 7]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE7.js"></script>
<![endif]-->
<!-- Javascript, jQuery -->
<script src="js/respond.src.js"></script>
<script type="text/javascript" src="js/flow.js"></script>
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
	<!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 >Login</h4>
        </div>
        <div class="modal-body">
          <?php 
			$sess = isset($_COOKIE['ci_session'])  ;
			$user_id = !empty($sess['user_id']) ? $sess['user_id'] : 0 ;
			$logged_in = $user_id ? true : false ;
			?>
			
			<form class="form-horizontal" role="form" method="post" action="admin/clients/">
					<div class="form-group">
						<label for="inputEmail1" class="control-label sr-only">Email</label>
						<div class="col-lg-10">
						  <input type="email" class="form-control" id="inputEmail1" placeholder="Email address" name="email">
						</div>
					</div>

			<div class="form-group">
				<label for="inputEmail1" class="control-label sr-only">Password</label>
				<div class="col-lg-10">
				  <input type="password" class="form-control" id="inputEmail1" placeholder="Password" name="password">
				</div>
			</div>

			 
	       		<div class="form-group">
	          		<div class="col-lg-10">
	          			<input type="submit" class="btn btn-success" value="Log in now">
	          			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	          		</div>
	          	</div>
	      		</form>
      		
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
	<div class="login-top"><? if (!$logged_in) : ?>
			<a data-toggle="modal" href="#myModal">Login</a>&nbsp;&#45;&nbsp;
			<a href="admin/clients/create_account">Create Account
			<? else : ?><a class="btn btn-danger" href="admin">Return to Control Panel</a><? endif ?></div>
		<div class="header"><a href="/" class="logo"><span>Clock In Point</span></a>
		</div>
		<?php include('includes/nav.php'); ?>
			<div class="subheader pull-left">
              	<img src="img/feature-image.gif" class="img-responsive">
            </div>
            
          		<?php include 'request-info.php';?>
          	
 			<div class="pull-left">
              <div class="span12">
                <div class="padding"><h1>The most cost effective time &amp; attendance system available&nbsp;&#45;&nbsp;<span class="red-text">at the touch of a button...</span></h1>
                </div>
                    <p class="front">ClockinPoint is an innovative, low cost attendance validation system which can be used to monitor contractual time, ensure accuracy of account payments, detect under or over performance, reveal absence and lateness, identify anomalies and provide supporting evidence.</p>
                    
                </div>
          	</div>

          <?php include 'includes/panel.php'; ?> 

          <div class="footer">
          	<div class="pull-left copyright">
          		&copy;<?php echo date('Y'); ?> Clockinpoint<br />
          		all rights reserved
          	</div>

          	<div class="pull-right links">
          		<a href="">Sitemap</a> | <a href="contact">Contact</a>
          	</div>
          </div>
</div><!-- End container -->
</body>
</html>