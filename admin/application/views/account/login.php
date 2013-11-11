<h1>Account Login</h1>
<? if ($error) : ?>
<p class="text-error"><?=$error?></p>
<? endif ?>

<? if ($message = $this->session->flashdata('message')) : ?>
<div class="alert alert-success"><strong>Info: </strong> <?=$message?></div>
<? endif ?>


<form class="form-horizontal" action="" method="post" id="login-form">
	<div class="control-group">
		<label class="control-label" for="inputEmail">Email</label>
		<div class="controls">
			<input name="email" type="text" id="inputEmail" placeholder="Email" autofocus>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputPassword">Password</label>
		<div class="controls">
			<input name="password" type="password" id="inputPassword" placeholder="Password">
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<?php /*?><label class="checkbox">
				<input type="checkbox">
				Remember me </label><?php */?>
			<button type="submit" class="btn">Sign in</button>
		</div>
		<div class="controls"> <br />
			<a href="account/forgot_password">Forgot password</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="account/create">Create an account</a> </div>
	</div>
</form>
