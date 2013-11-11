<?php if ($update_success = $this->session->userdata('update_success')) { 
		echo '<div class="alert alert-success">'.$update_success.'</div>';
		echo br(1);
		echo '<a href="'.site_url().'clients/devices" class="btn btn-primary btn-sm">&laquo; Back to devices</a>';
	  }
 ?>