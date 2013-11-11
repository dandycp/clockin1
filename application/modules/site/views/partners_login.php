<h2>Partners Login</h2>
<?php
	if ($this->session->userdata('message')){ echo '<div class="alert alert-danger">'.$this->session->userdata('message'),'</div>'; }
?>
<form class="form-horizontal" method="post" action="<?php echo site_url(); ?>partners" role="form">

	<div class="form-group">
    <label class="col-sm-1 control-label">Email</label>
    <div class="col-sm-3">
      <input type="email" class="form-control" placeholder="Email" name="email">
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-1 control-label">Password</label>
    <div class="col-sm-3">
      <input type="password" class="form-control" placeholder="Password" name="password">
    </div>
  </div>
	<input type="submit" class="btn btn-success" value="Login" name="btn_login">

</form>