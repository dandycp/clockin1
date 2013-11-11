<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Clock In Point - <?php echo $title; ?> <?php if (show_404()) { echo '404 - Page not found'; } ?></title>
<base href="<?=base_url()?>">
<link href="<?php echo site_url(); ?>css/bootstrap.css" rel="stylesheet">
<link href="<?php echo site_url(); ?>css/jquery-ui.css" rel="stylesheet">
<link href="<?php echo site_url(); ?>css/styles.css" rel="stylesheet">
<link href="<?php echo site_url(); ?>css/bootstrap-responsive.css" rel="stylesheet">
<script src="<?php echo site_url(); ?>js/jquery.js"></script>
<script src="<?php echo site_url(); ?>js/timepicker.js"></script>
<script src="<?php echo site_url(); ?>js/reports.js"></script>
<script src="<?php echo site_url(); ?>js/jquery-ui.js"></script>
<script src="<?php echo site_url(); ?>js/bootstrap.js"></script>
<script src="<?php echo site_url(); ?>js/bootstrap-tooltip.js"></script>
<script>
$(document).ready(function() {  
$('.navbar').tooltip({
    	selector: "a"
	})
}); 
</script>
</head>
<body>
<?php echo $this->load->view('common/nav'); ?>
<div class="container">
