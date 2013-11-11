<script src="<?php echo site_url(); ?>js/timepicker.js" type="text/javascript"></script>
<script type="text/javascript">
var date = new Date();
date.setMonth(date.getMonth() + 1, 1);

$(function() {
	$("#from").datepicker({defaultDate: date});
	$("#to").timepicker();
});
</script>

<h3>Reports</h3>
<div class="reports-box-left">
	<div class="panel panel-default">
		<div class="panel-heading">Date Range - <small>The range in which you wish to generate a report</small></div>

		<div class="panel-body">
			<form action="reports/list_all" method="post" class="form-inline" role="form">
				<div class="form-group">
				    <div class="col-lg-12">
				      <input type="text" class="form-control" name="from" id="from" class="form-control" placeholder="Date From" value="">
				    </div>
  				</div>

  				<div class="form-group">
				    <div class="col-lg-12">
				      <input type="text" class="form-control" name="to" id="to" class="form-control" placeholder="Date To" value="">
				    </div>
  				</div>

  				<div class="form-group">
  					<div class="col-lg-3">
						<button type="submit" class="btn btn-success">Apply</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">Recent Reports</div>

		<div class="panel-body">
			A tablular list of recent run reports
		</div>
	</div>

	</div>

	<div class="reports-box-right">

		<div class="panel panel-default">
			<div class="panel-heading">Options</div>

			<div class="panel-body">
				Options box to show popup of options
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">Device Groups</div>

			<div class="panel-body">
			

				<table class="table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Group Name</th>
							<th></th>
						</tr>
					</thead>

					<tbody>
					<?php foreach ($device_groups as $item) : ?>
						<tr>
							<td><?php echo $item['id']; ?></td>
							<td><?php echo $item['group_name']; ?></td>
							<td>
								<div class="btn-group">
									<a href="" class="btn btn-warning">Edit</a>
									<a href="" class="btn btn-danger">Delete</a>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>

	</div>