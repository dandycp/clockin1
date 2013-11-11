<div class="page-header">
	<h4><?php echo $title; ?></h4>
</div>
<?php if (validation_errors()) { echo validation_errors('<div class="alert alert-danger">', '</div>'); } ?>
<?php if ($page['status'] == 0) { echo '<div class="alert alert-danger">Page is inactive</div>'; } else { if ($page['status'] == 1){ echo '';} } 
$id = $this->uri->segment(3);

?>
<form class="form-horizontal" role="form" action="<?php echo site_url(); ?>cms/edit_page/<?php echo $id; ?>" method="post">

	<div class="form-group">
    	<label for="inputEmail1" class="col-lg-2 control-label">Page Title</label>
	    <div class="col-lg-5">
	      <input type="text" class="form-control" name="title" value="<?php echo $page['title']; ?>">
	      <span class="help-block">Page title will also show in the browser</span>
	    </div>
  	</div>

  	<div class="form-group">
    	<label for="inputEmail1" class="col-lg-2 control-label">Description</label>
	    <div class="col-lg-5">
	      <input type="text" class="form-control" name="description" value="<?php echo $page['description']; ?>">
	      <span class="help-block">For SEO purposes max of 160 chars</span>
	    </div>
  	</div>

  	<div class="form-group">
    	<label for="inputEmail1" class="col-lg-2 control-label">Content</label>
	    <div class="col-lg-5">
			<textarea class="form-control" rows="3" name="content"><?php echo strip_tags($page['content']); ?></textarea>
	    </div>
  	</div>

  	<div class="form-group">
    	<label for="inputEmail1" class="col-lg-2 control-label">Slug/URL</label>
	    <div class="col-lg-5">
	      <input type="text" class="form-control" name="slug" value="<?php echo $page['slug']; ?>">
	      <span class="help-block">example: my new page will be transformed to my-new-page by the system</span>
	    </div>
  	</div>

  	<div class="form-group">
    	<label for="inputEmail1" class="col-lg-2 control-label">Status</label>
	    <div class="col-lg-2">
	    	<select name="status" class="form-control">
	    		<?php if ($page['status'] == 1) { ?>
	    		<option value="1" selected>Active</option>
	    		<option value="0">Inactive</option>
	    		<?php }
	    		if ($page['status'] == 0) { ?>
	    		<option value="0" selected>Inactive</option>
	    		<option value="1">Active</option>
	    		<?php } ?>
	    	</select>
	    </div>
  	</div>

  	<div class="form-group">
	    <div class="col-lg-5">
	      <input type="submit" class="btn btn-success" value="Edit &amp; Save">
	    </div>
  	</div>

</form>