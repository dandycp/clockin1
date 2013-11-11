<script type="text/javascript">
  $(document).ready(function() { 
    $("#add-friend").click(function(){
      $('#add-friend-container').fadeToggle();
      });
  });
</script>

<h3>Welcome <?php echo $this->session->userdata('first_name'); ?>, please use the navigation panel above to get started.</h3>

<div class="panel panel-default pull-left"  style="width: 49%; min-height:225px!important;">
	<div class="panel-heading">Account Info</div>
	<div class="panel-body">
		<ul style="padding: 0; margin:0; list-style: none;">
			<li>User: <strong><?php echo $this->session->userdata('first_name'); ?></strong></li> 
			<li>Access: <strong><?php echo ucfirst($this->account['type']); ?></strong></li>
			<li>Company: <strong><?php echo $this->account['company_name']; ?></strong></li>
			<li>Account Number: <strong><?php echo $this->account['account_number']; ?></strong></li>
		</ul>
	</div>
</div>

<div class="panel panel-default pull-right"  style="width: 49%; min-height:225px!important;">
	<div class="panel-heading">Invite to ClockinPoint</div>
	<div class="panel-body">
		<p>Would you like to invite a contractor, client or contact to register a Clockin Point account?<br /><br />
		
			<strong>Please Note:</strong> If you wish to add a colleague to your exsiting account please go to the <code>options > users menu</code>, or contact your account administrator
		
		<br /><br /><a href="#" id="add-friend">Click here</a> to send them an invite</p>
		<?php
			$msg = $this->session->userdata('message');
			if (!isset($msg)) { echo 'not set'; } else { echo ''; }
		?>
			<div id="add-friend-container" style="display: none; width:400px;">
			<p>Enter your friend email address and a note then click send</p>
			<form action="<?php echo site_url(); ?>clients/send_to_friend" method="post" class="form-horizontal" role="form">


				<div class="form-group">
					<div class="col-lg-9">
			    		<label>Your Name</label>
			    		<input type="text" name="your_name" autofocus class="form-control">
			  		</div>
			  	</div>

			  	<div class="form-group">
					<div class="col-lg-9">
			    		<label>Your Email</label>
			    		<input type="text" name="your_email" autofocus class="form-control">
			  		</div>
			  	</div>


			  	<div class="form-group">
					<div class="col-lg-9">
			    		<label>Invite Name</label>
			    		<input type="text" name="friend_name" autofocus class="form-control">
			  		</div>
			  	</div>

				<div class="form-group">
					<div class="col-lg-9">
			    		<label>Invite Email</label>
			    		<input type="text" name="friend_email" autofocus class="form-control">
			  		</div>
			  	</div>


			 

			  	<div class="form-group">
					<div class="col-lg-9">
			    		<label>Comments</label>
			    		<textarea class="form-control" name="comments" rows="5"></textarea>
			  		</div>
			  	</div>

			  	<div class="form-group">
					<div class="col-lg-1">
						<button type="submit" class="btn btn-success">Send</button>
					</div>
				</div>

			</form>
		</div>
	
	</div>
</div>
<div style="clear:both;"></div>

<?php
if ($this->account['type'] === 'basic'){
	echo '<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			You currently have a Basic User Account, which only allows you to register and use a limited online service for 1 device. If you wish to add more devices, or access additional reporting functions, click <a href="'.site_url().'clients/account/change_package">here</a>
		  </div>';
} 

?>