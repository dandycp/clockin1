<!-- Device calibrate -->
	<div class="container">
	<div class="pull-left">
	
		<div id="bg">
			<div id="device" class="ui-widget-content">
				<div id="screen"><span style="position: relative; font-family: monospace; font-size: 28px; top: 14px; left: 25px; padding: 40px 0px 0px 22px;">PROGRAM</span></div>
				<div id="bit"></div>
				<div id="round-button"></div>
				<div id="clock"></div>
				<div id="cip"><img src="<?php echo site_url(); ?>images/logo.png" /></div>
			</div>
		</div>
	
	</div>
    
    <div class="pull-right" style="width: 450px; margin: 10px 20px 0px 0px;">

		<h2>Register device</h2>
		<h3>Step 2 - Calibration for <?=$device->name?></h3>
		 			

		<!-- Form actions -->
		<div class="form-actions">
			
			<p id="msg">Hold your unit up to the screen infront of the image.<br />Adjust the image size using <img src="<?php echo site_url(); ?>images/drag.png"> 
				        if necessary, so unit fits perfectly onto the image and click below.</p>
			<a id="btn-start" class="btn btn-success">Begin Calibration for <?=$device->name?></a> 
			<a id="btn-done" class="btn btn-success" style="padding: 10px;" href="<?php echo site_url(); ?>clients/devices/calibration_complete">I'm done</a>
		</div>

		<!-- Show epilepsy warning -->
		<div style="color: #C5253B; background: #F8F8F8; padding: 15px; font-size: 16px;">
			<strong>WARNING</strong><br />
			This process contains flashing lights which may <strong><u>not</u></strong> be suitable for photosensitive epilepsy.
		</div>
		
	</div>

</div>
<style>
#round-button { position: relative; border: 2px solid #cdcdcd; border-radius: 40px; width: 2cm; height: 2cm; top:100px; left:190px; background: #fff;}
#screen { position: relative; border: 2px solid #cdcdcd; width:6cm; top: 2cm; left: 3cm; height: 2cm; background: #fff; border-radius: 6px; -moz-border-radius: 6px; radius:6px;}
#bg { background:transparent; width:130mm; height:150mm; position:relative; }
#device { width:510mm; height:480mm; position:absolute; left:10mm; top:10mm; border:5px solid black; max-width: 12.5cm; max-height: 12.5cm; background: #e2e0e0; border-radius: 12px; -moz-border-radius: 12px; radius:6px;}
#bit { width:30mm; height:30mm;	border:2px solid #cdcdcd; position:absolute; left:1cm; top:5.5cm;  background: #fff; }
#clock { width:30mm; height:30mm; border:2px  solid #cdcdcd; position:absolute; right:1cm; top:5.5cm; background: #fff;}
#cip { bottom: 0px; font-size: 11px; position: relative; top: 6.4cm; left:4cm;}
#btn-done { display:none; }
</style>

<script>
var device_id = <?=$device->id?>;

</script

<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script>
	$(function() {
		$( "#device" ).resizable();
	});
</script>