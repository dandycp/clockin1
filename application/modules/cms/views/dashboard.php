<h3 style="border-bottom: 1px solid #cdcdcd; margin-bottom: 18px; padding-bottom: 4px;">Hi there, <?php echo $this->session->userdata('first_name'); ?></h3>

<!-- Panels for Quick/Ease of use viewing -->
<div class="pull-left" style="min-width: 510px;">
	<div class="panel panel-default">
		<div class="panel-heading">Active Clients&nbsp;&nbsp;&nbsp;<?php echo pager(site_url('cms/dashboard'), 'cms_model'); ?></div>
			<div class="panel-body">
			<?php if ($registrations) { ?>
				
				<table class="table table-hover table-condensed">
					<thead>
						<tr>
							<th>Account ID</th>
							<th>Name</th>
							<th>Email</th>
							<th>Tel</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($registrations as $item) { ?>
						<tr>
							<td><?php echo $item['account_id']; ?></td>
							<td><?php echo ucfirst($item['first_name']); ?>&nbsp;<?php echo ucfirst($item['last_name']); ?></td>
							<td><a href="mailto:<?php echo $item['email'];?>"><?php echo $item['email']; ?></a></td>
							<td><?php echo $item['tel']?></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
				<?php echo pager(site_url('cms/dashboard'), 'cms_model'); ?>
				
			<?php } ?>
			</div>
	</div>
</div>
<div class="pull-right" style="min-width: 510px;">
	<div class="panel panel-default">
		<div class="panel-heading">Financials</div>
			<div class="panel-body">
				Some data on financial info
			</div>
	</div>
</div>