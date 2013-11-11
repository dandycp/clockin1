<div class="page-header">
	<h4><?php echo $title; ?></h4>
</div>
<?php if (validation_errors()) { echo validation_errors('<div class="alert alert-danger">', '</div>'); } ?>
<form class="form-horizontal" role="form" action="<?php echo site_url(); ?>cms/create_page" method="post">

	<div class="form-group">
    	<label for="inputEmail1" class="col-lg-2 control-label">Page Title</label>
	    <div class="col-lg-5">
	      <input type="text" class="form-control" name="title">
	      <span class="help-block">Page title will also show in the browser</span>
	    </div>
  	</div>

  	<div class="form-group">
    	<label for="inputEmail1" class="col-lg-2 control-label">Description</label>
	    <div class="col-lg-5">
	      <input type="text" class="form-control" name="description">
	      <span class="help-block">For SEO purposes max of 160 chars</span>
	    </div>
  	</div>

  	<div class="form-group">
    	<label for="inputEmail1" class="col-lg-2 control-label">Content</label>
	    <div class="col-lg-5">
			<textarea class="form-control" rows="3" name="content"></textarea>
	    </div>
  	</div>

  	<div class="form-group">
    	<label for="inputEmail1" class="col-lg-2 control-label">Slug/URL</label>
	    <div class="col-lg-5">
	      <input type="text" class="form-control" name="slug">
	      <span class="help-block">example: my new page will be transformed to my-new-page by the system</span>
	    </div>
  	</div>

  	<div class="form-group">
    	<label for="inputEmail1" class="col-lg-2 control-label">Status</label>
	    <div class="col-lg-2">
	    	<select name="status" class="form-control">
	    		<option value="1">Active</option>
	    		<option value="0">Inactive</option>
	    	</select>
	    </div>
  	</div>

  	<div class="form-group">
	    <div class="col-lg-5">
	      <input type="submit" class="btn btn-success" value="Create">
	    </div>
  	</div>

</form>