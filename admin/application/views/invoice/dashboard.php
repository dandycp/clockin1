<h3>Invoices</h3>
<div class="panel panel-default">
  <div class="panel-heading"><span style="font-weight: bold;">Oustanding Invoices</span></div>
  <div class="panel-body">
  <?php if ($inv['invoice_status'] = 'unpaid') { ?>
    	<table class="table">
			<thead>
				<tr>
					<th>Invoice No</th>
					<th>Invoice Amount</th>
					<th>Invoice Date</th>
					<th>Due Date</th>
					<th>Status</th>
					<th>Duration</th>
					<th>Days Overdue</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($invoices as $invoice): 
				// Set default timezone and set offset from due date to todays date
				date_default_timezone_set('Europe/London');
				$datetime1 = new DateTime($invoice['invoice_due_date']);
				$datetime2 = new DateTime();
				$interval = $datetime1->diff($datetime2);
			?>
				<tr>
					<td><?php echo $invoice['invoice_id']; ?></td>
					<td>&pound;<?php echo $invoice['invoice_amount']; ?></td>
					<td><?php echo $invoice['invoice_date']; ?></td>
					<td><?php echo $invoice['invoice_due_date']; ?></td>
					<td>
						<?php if ($invoice['invoice_status'] == 'paid') { echo '<span class="label label-success">'.$invoice['invoice_status'].'</span>'; } ?>
						<?php if ($invoice['invoice_status'] == 'processing') { echo '<span class="label label-warning">'.$invoice['invoice_status'].'</span>'; } ?>
						<?php if ($invoice['invoice_status'] == 'unpaid') { echo '<span class="label label-danger">'.$invoice['invoice_status'].'</span>'; } ?>
					</td>
					<td><?php echo ucfirst($invoice['invoice_interval']); ?></td>
					<td><?php if ($invoice['invoice_status'] == 'unpaid') { echo $interval->format('%d days'); } ?></td>
					<td>
						<div class="btn-group btn-group-xs">
							<a href="<?php echo site_url(); ?>clients/view_invoice/<?php echo $invoice['invoice_id']; ?>" class="btn btn-warning">View</a>
							<?php if ($invoice['invoice_status'] == 'unpaid') { ?><a href="" class="btn btn-success">Pay</a><?php }?>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
    	</table>
    <?php }
    else { echo 'No oustanding invoices'; }
    ?>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading"><span style="font-weight: bold;">Current Subscriptions</span></div>
  <div class="panel-body">
    	<table class="table">
			<thead>
				<tr>
					<th>No of Devices</th>
					<th>Amount</th>
					<th>Duration</th>
					<th>Due Date</th>
					<th>Active</th>
					<th></th>
				</tr>
			</thead>

			<tbody>
			<?php foreach ($subscriptions as $item) : ?>
				<tr>
					<td><?php echo $item['num_devices']; ?></td>
					<td>&pound;<?php echo $item['amount']; ?></td>
					<td><?php echo ucfirst($item['interval']); ?></td>
					<td><?php echo $item['next_payment_due']; ?></td>
					<td><?php if ($item['active'] == 1) { echo '<span class="label label-success">Yes</span>'; } else { '<span class="label label-danger">No</span>'; } ?></td>
					<td>
						<div class="btn-group btn-group-xs">
							<a href="" class="btn btn-warning">View</a>
							<a href="" class="btn btn-danger">Remove</a>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
    	</table>
  </div>
</div>