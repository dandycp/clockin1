
<?php $this->load->view('reports/header')?>
<h2>Reports</h2>



<div class="row">
<div class="pull-left">
	<div class="calendar_left">
		<h3 class="h3tag">Date Range</h3>
	<form id="date-control" class="form" action="reports/times" method="post">
		
		<div class="pull-left">

			<input type="text" name="from" id="from" class="input-medium" placeholder="Date From" value="<?php $this->report->get_from('M j, Y')?>" /><br />
			<br />
			<button type="submit" class="btn"><i class="icon-ok-sign"></i> Apply</button>
			
		</div>
		&nbsp;
		<div class="pull-right">
			<input type="text" name="to" id="to" class="input-medium" placeholder="Date To" value="<?php $this->report->get_to('M j, Y')?>" /><br />
				
		</div>
	</form>
</div>
	<div class="box move">
		<h3 class="h3tag">Recent Reports - <small><a href="reports/stored_reports">View all</a></small></h3>
			<?php if (!empty($saved_reports)) { ?>
			<table class="table table-striped table-condensed">

				<thead>
					<th>Report</th>
					<th>Created</th>
					<th></th>
				</thead>
				<tbody>
					<?php 
					$datestring = "%d/%m/%Y";
					foreach ($saved_reports as $reports) { 
					?>
					<tr>
						<td><?php echo $reports['other']; ?></td>
						<td><?php echo mdate($datestring, strtotime($reports['created'])); ?></td>
						<td><a href="<?php echo base_url(); ?>userfiles/stored_reports/<?php echo $reports['file']; ?>"><button class="btn btn-mini"><i class="icon-download"></i> Download</button></a></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php } 
			else {
				echo '<p class="alert alert-error">No saved reports.</p>';
			}
			?>
	</div>


</div>

<div style="margin: 2px 0px 5px 35px;">
	

	<div class="box">
		<h3 class="h3tag">Options</h3>
		<table class="table table-striped datatable client-report table-condensed">
		<thead>
		<tr>
			
			
			<th class="initially-hidden">Batch Ref<br />
			<input type="text" class="input-filter input-small" /></th>
						
			<th class="initially-hidden">Address<br />
			<input type="text" class="input-filter input-small"></th>
			
			<th class="initially-hidden">Location<br />
			<input type="text" class="input-filter input-small"></th>
			
			<th class="initially-hidden">Usergroup<br />
			<select class="select-filter"></select></th>
			
			<th class="initially-hidden">Person<br />
			<select class="select-filter"></select></th>
			
			<th class="initially-hidden">Category<br />
			<select class="select-filter"></select></th>
			
						
			
		</tr>
		</thead>
	</table>
	</div>


	

	<div class="box">
		<h3 class="h3tag">Device Groups</h3>
	Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Maecenas faucibus mollis interdum.
	</div>




</div>

<?php $this->load->view('reports/footer')?>
