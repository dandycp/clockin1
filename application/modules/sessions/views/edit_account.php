<h3>Edit My Account</h3>
<form class="form-horizontal" role="form" action="<?php echo site_url(); ?>sessions/edit" method="post">

	<div class="form-group">
    	<label for="inputEmail1" class="col-lg-1 control-label">Name</label>
	    <div class="col-lg-4">
	      <div class="pull-left"><input type="text" class="form-control col-lg-3" name="first_name" value=""></div>
	      <div class="pull-right"><input type="text" class="form-control col-lg-3" name="last_name" value=""></div>
	    </div>
  	</div>

  	<div class="form-group">
    	<label for="inputEmail1" class="col-lg-1 control-label">Username</label>
	    <div class="col-lg-3">
	      <input type="text" class="form-control" name="username" value="">
	    </div>
  	</div>

  	<div class="form-group">
    	<label for="inputEmail1" class="col-lg-1 control-label">Password</label>
	    <div class="col-lg-3">
			<input type="password" class="form-control" name="password" value="">
			<span class="help-block">Leave blank for unchanged</span>
	    </div>
  	</div>

  	<div class="form-group">
	    <div class="col-lg-5">
	      <input type="submit" class="btn btn-success" value="Save">
	    </div>
  	</div>

</form>