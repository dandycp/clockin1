<script type="text/javascript">
// Shows messages then removes after 3 seconds
window.setTimeout(function() {
    $(".alert alert-success").fadeTo(300, 0).slideUp(100, function(){
        $(this).remove(); 
    });
}, 3000);
</script>
<h2>Notifications</h2>

<?php if ($this->session->flashdata('message')) { ?>
<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;&nbsp;<?php echo $this->session->flashdata('message'); ?><a class="close" data-dismiss="alert" href="#">&times;</a></div>
<?php } ?>

<?php
if(empty($message)) {
	echo '<div class="alert">No new notifications</div>';
}
else { ?>
	<table class="table table-striped datatable">
		<thead>
			<th>Message</th>
			<th>Sent</th>
			<th>Action</th>
		</thead>
	<?php foreach ($message as $item) { ?>
		<tbody>
			<td><?php if ($item['status'] == 0) { echo'<span class="strike muted"">'.word_limiter($item['message_content'], 30).'</span>'; } else { echo word_limiter($item['message_content'], 30); } ?></td>
			<td><?php echo $item['created']; ?></td>
			<td><a href="" class="btn btn-success">Approve</a> <a href="" class="btn btn-danger">Decline</a><?php if ($item['status'] == 0) { echo '<span class="label label-important"><i class="icon-book icon-white"></i> Marked as Read</span>'; } else { ?><a class="btn" href="account/read_notification/<?php echo $item['id']; ?>"><i class="icon-book"></i> Mark as read</a><?php } ?> 
			<a class="btn" href="account/delete_notification/<?php echo $item['id']; ?>" onclick="return confirm('Are your sure you wish to remove this notification?');"><i class="icon-remove"></i> Delete</a></td>
		</tbody>
	<?php } ?>
	</table>
<?php } ?>