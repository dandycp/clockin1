<?php
if (count($result)){
	echo "<h5>Search Results&nbsp;-&nbsp;";
	echo (count($result));
	echo " results found</h5><div class='well' id='groups'>Do you wish to group these devices?<br /><a href='#' id='group-device' class='btn btn-success'>Yes</a>&nbsp;<a href='#' id='no-show' class='btn btn-danger'>No</a><br /><br /><form action='".site_url()."clients/devices/group_device' method='post' role='form' id='user-input' class='form-inline'><input type='text' name='userinput' onfocus='if(this.value == 'Enter group name'){this.value = '';}' onblur='if(this.value == ''){this.value='Enter group name';}' value='Enter group name' class='form-control' style='width:200px;'>&nbsp;<button class='btn btn-success'>Save</button</form></div>";
?>
		
		<table class="table table-striped">
			<thead>
				<th>Device</th>
				<th>Location</th>
				<th>Address</th>
				<th>Postcode</th>
			</thead>
<?php foreach ($result as $key => $list){ ?>
			<tr>
			
				<td><a href="<?php echo site_url(); ?>clients/devices/edit/<?php echo $list['id']; ?>"><?php echo $list['name']; ?></a></td>
				<td><?php echo $list['location']; ?></td>
				<td><?php echo $list['line_1']; echo $item['line_2']; echo $item['city']; ?></td>
				<td><?php echo $list['postcode']; ?></td>
			
			</tr>
		
	
<?php
	}
	echo '</table>';
}

else{
	echo "<div class='headerbar'><h1>Sorry!</h1></div>";
	echo (count($result))."&nbsp;results were found to match your search term.";
	echo "<p>Please try again</p>";
}
?>