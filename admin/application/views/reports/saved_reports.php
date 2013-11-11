<h2>Saved Reports</h2>
<?php if ($this->session->flashdata('message')) { ?>
<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;&nbsp;<?php echo $this->session->flashdata('message'); ?><a class="close" data-dismiss="alert" href="#">&times;</a></div>
<?php } ?>

<?php if (!empty($saved_reports)) { ?>
<table class="table table-striped">
	<thead>
		<th>Report Name</th>
		<th>File</th>
		<th>Created</th>
		<th>Status</th>
		<th></th>
	</thead>
	
	<tbody>
	<?php $datestring = "%d/%m/%Y - %h:%i %a";
	foreach ($saved_reports as $reports) { 
	?>
		<tr>
			<td><?php echo $reports['other']; ?></td>
			<td><?php echo $reports['file']; ?></td>
			<td><?php echo mdate($datestring, strtotime($reports['created'])); ?></td>
			<td><?php echo $reports['status']; ?></td>
			<td><a href="<?php echo base_url(); ?>userfiles/stored_reports/<?php echo $reports['file']; ?>"><button class="btn btn-mini"><i class="icon-download"></i> Download</button></a>
				<a href="<?php echo base_url(); ?>reports/remove_reports/<?php echo $reports['id']; ?>"><button class="btn btn-mini"><i class="icon-remove"></i> Remove</button></a></td>
		</tr>

	<?php } ?>
	</tbody>
</table>
<?php
}
else { echo 'No saved reports.'; }

?>