<h1>Forgotten Password?</h1>
<p>Enter your email to reset your password.</p>

<? if ($error) : ?>
<p class="text-error"><?=$error?></p>
<? endif ?>

<form action="" method="post" class="form-inline" role="form">
		

	<div class="form-group">
    	<label for="exampleInputEmail2">Email</label>
    	<input type="text" class="form-control" name="email" value="<?=$data['email']?>">
  	</div>
	
<br /><br />
	
	<div class="form-group">
			<div class="col-lg-0">
		<button type="submit" class="btn btn-success btn-large">Submit</button>
		</div>
	</div>


	
</form>