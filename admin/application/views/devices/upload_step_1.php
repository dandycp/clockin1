<script type="text/javascript">
$(document).ready(function() { 
    $("#otherbtn").click(function(){
    	$("step2").show();
    	$("download_area").hide();
    });   
});
</script>
<?php if (isset($error)) { echo '<div class="alert alert-danger"><strong>Ooops Sorry!</strong>'.$error.'</div>'; } else { echo ''; } ?>
<div class="well" id="download_area">
	In order to upload your data you must first download our template, this enures the correct format is uploaded.<br />
	Click the button below to download.<br /><br />
	<a href="<?php echo site_url(); ?>devices/export" class="btn btn-info" id="download">Download</a>
	<br /><br />
		Alternatively if you already have the template you can upload your file by clicking below<br />
		<?php echo form_open_multipart('devices/do_upload');?>
		<div class="form-group">
	    	<input type="file" name="userfile">
	 	</div>
	    <button class="btn btn-primary" type="submit">Upload</button>
	</form>
	
</div>

<div id="step2" class="well">
	<h4>Thank you, now complete the template with your data then upload</h4>
	<?php echo form_open_multipart('devices/do_upload');?>
		<div class="form-group">
	    	<input type="file" name="userfile">
	 	</div>
	    <button class="btn btn-primary" type="submit">Upload</button>
	</form>
</div>
