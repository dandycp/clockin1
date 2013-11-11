<ul class="nav nav-tabs" style="border:none!important; outline: none;">
	<li style="border:none!important; outline: none;"><a href="#dashboard" data-toggle="tab" class="active">Dashboard</a></li>
	<li style="border:none!important; outline: none;"><a href="" data-toggle="tab"></a></li>
	<li style="border:none!important; outline: none;"><a href="#account" data-toggle="tab">Account</a></li>
	<li style="border:none!important; outline: none;"><a href="#logout" data-toggle="tab">Logout</a></li>
</ul>

<div class="tab-content" style="border:none; outline:none">
  <div class="tab-pane fade in active" id="dashboard" style="border:none!important; outline: none;">
  	<h3>Hi, <?php echo $this->session->userdata('name'); ?></h3>
  </div>

  <div class="tab-pane fade" id="profile" style="border:none!important; outline: none;">
  	
  </div>

  <div class="tab-pane fade" id="account" style="border:none!important; outline: none;">
  	My Account page
  </div>

  <div class="tab-pane fade" id="logout" style="border:none!important; outline: none;">
  	<div class="well">
  		<p>Are you sure you wish to logout?</p>
  		<p><a href="logout" class="btn btn-warning">Logout</a></p>
  	</div>
  </div>

</div>