<div class="alert alert-info"><p>Before you upload a list of the people you must first download our template <a href="<?php echo site_url(); ?>people/export">here</a></p></div>

<?php echo form_open_multipart('people/upload');?>
		<div class="form-group">
	    	<input type="file" name="userfile">
	 	</div>
	    <button class="btn btn-primary" type="submit">Upload</button>
	</form>