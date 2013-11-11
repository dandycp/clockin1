<h2>Account Login</h2>
<? if (isset($error)) : ?>
<?php echo $error; ?>
<? endif ?>

<? if ($message = $this->session->flashdata('message')) : ?>
<div class="alert alert-success"><strong>Success: </strong> <?=$message?></div>
<? endif ?>
<? if ($logged_out = $this->session->flashdata('logged_out')) : ?>
<div class="alert alert-success"><strong>Success: </strong> <?php echo $logged_out; ?></div>
<? endif ?>

<? if ($error_msg = $this->session->flashdata('error')) : ?>
<div style="color: #C5253B!important; background: #F8F8F8!important; padding: 15px!important; font-size: 16px!important;"><strong>Error: </strong> <?=$error_msg?></div>
<? endif ?>

<form class="form-horizontal" role="form" action="<?php echo site_url();?>clients/login" method="post">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Email</label>
    <div class="col-lg-3">
      <input type="email" class="form-control" id="inputEmail1" placeholder="Email" name="email">
      <?php $email = $this->input->post('email'); if (empty($email)) { $error = '<span class="label label-danger">Email address is required</div>'; } ?>
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword1" class="col-lg-2 control-label">Password</label>
    <div class="col-lg-3">
      <input type="password" class="form-control" id="inputPassword1" placeholder="Password" name="password">
      <?php $password =  $this->input->post('password'); if (empty($password)) { $error = '<span class="label label-danger">Password is required</div>'; } ?>
    </div>
  </div>
 
  <div class="form-group">
    <div class="col-lg-offset-1 col-lg-4">
      <button type="submit" class="btn btn-success">Sign in</button><br /><br />
      <a href="<?php echo site_url();?>clients/forgot_password">Forgot password</a>&nbsp;&nbsp;/&nbsp;&nbsp; <a href="<?php echo site_url('clients/create_account');?>">Create an account</a> 
    </div>
  </div>
 </form>


