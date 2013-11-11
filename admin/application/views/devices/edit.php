
<? if ($error) : ?>
<div class="alert alert-error"><strong>Error: </strong><?=$error?></div>
<? endif ?>
<ul class="nav nav-tabs">
  <li><a href="#devices" data-toggle="tab" style="border: none!important; outline: none; ">Devices</a></li>
  <li><a href="#groups" data-toggle="tab" style="border: none!important; outline: none; ">Groups</a></li>
  <li><a href="" data-toggle="modal" data-target="#codesModal">Codes</a></li>
</ul>
<div class="tab-content" style="border: none!important; outline: none;">
<div id="devices" class="tab-pane active" style="border: none!important; outline: none;">
	<div class="pull-left" style="width: 500px;">
	<form class="form-horizontal" action="" method="post">
		<h3>Manage Device</h3>
		<div class="form-group">
			<div class="col-lg-8">
		    <label>Device Name</label>
		    
		      <input type="text" class="form-control" name="name" value="<?=$device->name?>">
		      <span class="help-block">Give your device a name. This will be used to identify the device in future reporting.</span>
		    </div>
		  </div>
		
		
			<legend><span>About The Location</span></legend>
			<div class="form-group">
			<div class="col-lg-12">
			<?=$this->load->view('common/address', compact('address', 'countries'))?>
			</div>
			</div>
			
			<div class="form-group">
			<div class="col-lg-8">
		    <label>Device Location</label>
		    
		      <textarea name="location" rows="3" class="form-control"><?=$device->location?></textarea>
		      <span class="help-block"><small>eg: "<em>Inside of house, on the right of the front door.</em>"</small></span>
		    </div>
		  </div>

			<legend><span>Settings</span></legend>
			
				
			<div class="form-group">
			<div class="col-lg-8">
		    <label>Max code reuse</label>
		      <input type="number" name="max_code_reuse" size="2" class="form-control" value="<?=$device->max_code_reuse?>" />
		      <span class="help-block">Limits how many times the same code can be reused</span>
		    </div>
		  </div>

		  <div class="form-group">
		    <div class="col-lg-8">
		    	<label>Tolerance Rate</label>
		      <input type="text" class="form-control" value="<?php echo $client->tolerance_rate; ?>" name="tolerance_rate">
		    </div>
	    </div>

	    <div class="form-group">
			<div class="col-lg-4">
				<a href="" class="btn btn-primary" data-toggle="modal" data-target="#codesModal">See codes for device</a>
			</div>
	    </div>
	    <!-- model window for showing codes -->
			<div class="modal fade" id="codesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        <h4 class="modal-title" id="myModalLabel" style="border: none;">Codes for <?=$device->name;?></h4>
			      </div>
			      <div class="modal-body">
			        	<table class="table table-condensed">
							<thead>
								<tr>
									<th>Start Code</th>
									<th>End Code</th>
									<th>Ref No</th>
									<th>Added At</th>
								</tr>
							</thead>
							<?php foreach ($device_codes as $code) { ?>
							<tbody>
								<tr>
									<td><?php if (empty($code['code'])) { echo 'N/A'; } else { echo $code['code']; } ?></td>
									<td><?php if (empty($code['end_code'])) { echo 'N/A'; } else { echo $code['end_code']; } ?></td>
									<td><?php if (empty($code['batch_ref'])) { echo 'N/A'; } else { echo $code['batch_ref']; } ?></td>
									<td><?php echo $code['time']; ?></td>
								</tr>
							</tbody>
							<?php } ?>
			        	</table>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-success" data-dismiss="modal">OK Close</button>
			        <a href="<?php echo site_url(); ?>clients/devices/run_report/<?php echo $this->uri->segment(4); ?>" class="btn btn-primary">Report</a>
			        
			      </div>
			    </div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
		
		<!-- end modal window -->
		<div class="form-group">
			<div class="col-lg-1">
				<button type="submit" class="btn btn-success btn-large">Submit</button>
			</div>
		</div>
	</form>
	</div>
	<div class="pull-right" style="width: 550px;">
		<h3>Re-allocate Device</h3>
		<p>If you wish to re-allocate this device to a new location you can do so by clicking <a href="" id="reallocate">here</a> to enter a new address whilst keeping the same settings &amp; codes.</p>
		<div id="new-address">
			<form action="" method="post" class="form-horizontal">
				  	<div class="form-group">
  		<div class="col-lg-4">
    	<label >Address</label>
      			<input type="text" class="form-control" name="address[line_1]" value="<?php echo $address['line_1'];?>">
    		</div>
  	</div>


	  <div class="form-group">
	  	<div class="col-lg-4">
	  	<label>Address (optional)</label>
	      <input type="text" class="form-control" name="address[line_2]" value="<?php echo $address['line_2'];?>">
	    </div>
	  </div>

	  <div class="form-group">
	  	<div class="col-lg-4">
	    <label>City/Town</label>
	    
	      <input type="text" class="form-control" name="address[city]" value="<?php echo $address['city'];?>">
	    </div>
	  </div>

	  <div class="form-group">
	  	<div class="col-lg-4">
	    <label>Postcode</label>
	    
	      <input type="text" class="form-control" name="address[postcode]" value="<?php echo $address['postcode'];?>">
	    </div>
	  </div>

	  <div class="form-group">
	  	<div class="col-lg-4">
	    <label>Country</label>
	    
	      <select name="address[country_id]" class="form-control">
			<? foreach ($countries as $country) : ?>
			<option value="<?php echo $country['id'];?>"  <? if ($address['country_id'] == $country['id']) echo 'selected="selected"' ?>>
			<?php echo $country['name'];?>
			</option>
			<? endforeach ?>
		</select>
	    </div>
	  </div>
			</form>
		</div>
	</div>
</div><!-- end  -->


	<div id="groups" class="tab-pane" style="border: none!important; outline: none;">
		<h3>Device Groups</h3>
		<table class="table">
			<thead>
				<tr>
					<th>Group Name</th>
					<th>Created By</th>
					<th></th>
				</tr>
			</thead>
			<?php foreach($device_groups as $item) { ?>
			<tbody>
				<tr>
					<td><?php echo $item['group_name']; ?></td>
					<td><?php echo $this->session->userdata('username');?> on <?php echo $item['created']; ?></td>
					<td>
						<div class="btn-group" data-toggle="buttons">
							<a href="" class="btn btn-success">Show</a>
							<a href="<?php echo site_url(); ?>clients/devices/delete_group/<?php echo $item['id']; ?>" class="btn btn-danger">Delete</a>
						</div>
					</td>
				</tr>
			</tbody>
			<?php } ?>
		</table>
		
	</div>
</div><!-- tabs content group -->