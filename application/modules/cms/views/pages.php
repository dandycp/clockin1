<div class="page-header">
	<a href="<?php echo site_url(); ?>cms/create_page" class="btn btn-primary">Create New</a>
</div>
<?php if ($this->session->flashdata('alert_success')) { ?>
	<div class="alert alert-success"><?php echo $this->session->flashdata('alert_success'); ?></div>
<?php } ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>ID</th>
			<th>Title</th>
			<th>Content</th>
			<th>Active</th>
			<th>Path/URL</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		if ($page) {
			
		foreach ($page as $item) {
		?>
		<tr>
			<td><?php echo $item['id']; ?></td>
			<td><?php echo $item['title']; ?></td>
			<td><?php echo strip_tags(strtolower(word_limiter($item['content'], 30))); ?></td>
			<td><?php if ($item['status'] == 1) { echo '<span class="badge" style="background: green;">&#10003;</span>'; } else { echo '<span class="badge" style="background: red;">X</span>'; } ?></td>
			<td><?php echo $item['slug']; ?></td>
			<td>
				<a href="<?php echo site_url('cms/edit_page/' . $item['id']); ?>" title="Edit">Edit</a>&nbsp;|&nbsp;<a href="<?php echo site_url('cms/delete_page/' . $item['id']); ?>" title="Delete" onclick="return confirm('Are you sure you wish to remove this item?');">Delete</a>
			</td>
		</tr>
		<?php		
			}
		}
		?>
	</tbody>
</table>