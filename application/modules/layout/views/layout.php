<!DOCTYPE html>
<html lang="en">
<head>
<title>webCMS - <?php echo $title; ?></title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Stylesheets -->
<link href="<?php echo site_url(); ?>css/bootstrap.css" rel="stylesheet" media="screen">
<link href="<?php echo site_url(); ?>css/admin.css" rel="stylesheet" media="screen">
<!--[if lt IE 7]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE7.js"></script>
<![endif]-->
<!-- Scripts -->
<script src="<?php echo site_url(); ?>js/jquery-latest.js"></script>
<script src="<?php echo site_url(); ?>js/bootstrap.js"></script>

</head>
<body>
	 <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo site_url(); ?>cms/dashboard">web<span class="cms">CMS</span></a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?php echo site_url(); ?>cms/pages">Pages</a></li>
            <li><a href="<?php echo site_url(); ?>cms/financials">Financials</a></li>
            <li><a href="">Reports</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
              <a href="" class="dropdown-toggle" data-toggle="dropdown">Account <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo site_url(); ?>sessions/edit/<?php echo $this->session->userdata('user_id'); ?>">Edit Account</a></li>
                <li><a href="<?php echo site_url(); ?>cms/sessions/logout">Logout</a></li>
              </ul>
            </li>
          </ul>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">

      <div class="content_area">
      	<?php echo $maincontent; ?>
      </div><!-- content area -->

    </div><!-- /.container -->
</body>
</html>