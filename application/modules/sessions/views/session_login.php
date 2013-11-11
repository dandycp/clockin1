<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>webCMS Login</title>
 
<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if lte IE 7]>
	<script src="js/IE8.js" type="text/javascript"></script>
<![endif]-->
<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" media="all" href="css/ie6.css"/>
<![endif]-->
<!-- Bootstrap -->
<link href="<?php echo site_url(); ?>css/bootstrap.css" rel="stylesheet">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }
      #logo {
	      text-align: center;      	
      }
      footer {
      	float: left;
      	margin: 0px 0px 3px 480px;
      	font-size: 11px;
      }
      .cms {
      	color: #3D7D9D;
      	font-weight: bold;
      }
    </style>

</head>
<body>


<div id="container_login" class="container">
	<div id="logo">
		<h3>web<span class="cms">CMS</span></h3>
	</div>
	<form class="form-signin" action="<?php echo site_url($this->uri->uri_string()); ?>" method="post">
        <h4 class="form-signin-heading">Login</h4>
        <?php
            $logged = $this->session->userdata('logout');
            if ($logged) { echo '<div class="alert alert-success">You are now logged out</div>'; }
            if (!$logged) { echo ''; }
          ?>
        <?php

		if ($this->session->flashdata('error')) {
			echo '<div class="alert alert-error">';
			echo '<button class="close" data-dismiss="alert">&times;</button>';
			echo $this->session->flashdata('error');
			echo '</div>';
		}
      if ($this->session->flashdata('access')) {
      echo '<div class="alert alert-error">';
      echo '<button class="close" data-dismiss="alert">&times;</button>';
      echo $this->session->flashdata('access');
      echo '</div>';
    }
		
		
	?>
        <input type="text" class="form-control" placeholder="Username" name="username">
        <input type="password" class="form-control" placeholder="Password" name="password">
        <input type="submit" name="btn_login" value="Login" class="btn btn-success">

      </form>
      
</div>
</body>
</html>