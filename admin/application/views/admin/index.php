<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CMS - Login</title>

    <link rel="stylesheet" href="<?php echo site_url(); ?>css/bootstrap3.css">
    <link rel="stylesheet" href="<?php echo site_url(); ?>css/client.css">

    <script src="<?php echo site_url(); ?>js/bootstrap3.js"></script>
    <script src="<?php echo site_url(); ?>js/jquery-10.js"></script>
    <script src="<?php echo site_url(); ?>js/jquery-ui.js"></script>
    <script src="<?php echo site_url(); ?>js/bootstrap.js"></script>
    <script src="<?php echo site_url(); ?>js/bootstrap-tooltip.js"></script>

    <!-- Custom styles for this template -->
    <link href="<?php echo site_url(); ?>css/admin-login.css" rel="stylesheet">
  </head>

  <body>
    <?php
      $cookie = array(
          'name'   => 'remember-me',
          'value'  => 'remember-me',
          'expire' => '86500',
          'domain' => base_url(),
          'path'   => '/',
          'secure' => TRUE
      );

    $this->input->set_cookie($cookie); 
    //var_dump($cookie);

    ?>
    <div class="container">

      <form class="form-signin">
        <h2 class="form-signin-heading">webCMS - Sign In</h2>
        <input type="text" class="form-control" placeholder="Username" autofocus>
        <input type="password" class="form-control" placeholder="Password">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
      </form>

    </div> <!-- /container -->

  </body>
</html>
