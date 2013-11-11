<?php 
//$sess = isset($_COOKIE['ci_session']) ? unserialize($_COOKIE['ci_session']) : array() ;
$user_id = !empty($sess['user_id']) ? $sess['user_id'] : 0 ;
$logged_in = $user_id ? true : false ;
?>

<div class="col-md-4" id="login-panel">
<? if (!$logged_in) : ?>
<h4>Request Info</h4>
<form class="form-horizontal" role="form" method="post" action="admin/clients/">
  <div class="form-group">
    <label for="inputEmail1" class="control-label sr-only">Email</label>
    <div class="col-lg-10">
      <input type="email" class="form-control" id="inputEmail1" placeholder="Email address" name=~"email">
    </div>
  </div>

  <div class="form-group">
    <label for="inputEmail1" class="control-label sr-only">Password</label>
    <div class="col-lg-10">
      <input type="password" class="form-control" id="inputEmail1" placeholder="Password" name="password">
    </div>
  </div>

  <button type="submit" class="btn btn-danger">Login</button>

</form>
<br />
<img src="img/bullet.gif" width="17" height="17"> <a href="admin/account/create">Create an account</a><br />
<img src="img/bullet.gif" width="17" height="17"> <a href="admin/account/forgot_password">Forgotten username/password</a>

<? else : ?>

<p>You are currently logged in.</p>
<p><a class="btn btn-danger" href="admin">Return to Control Panel</a></p>
<? endif ?>
</div> 