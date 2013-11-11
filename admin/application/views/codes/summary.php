<div class="summary">

<h1>Summary</h1>


<div class="well">
<strong>CIP Reference: </strong><?=$batch_ref?> - <a id="enter-ref" href="#">Enter your own</a><br />

	<form id="ref-form" class="form-inline" role="form" method="post" action="<?php echo site_url(); ?>clients/codes/update_batch_ref">
		<div class="form-group">
			<input name="batch_ref" type="text" class="input form-control" placeholder="Your reference" />
		</div>
			<button type="submit" class="btn btn-primary">Apply</button>
	</form>
</div>

<script>
$(function() {
	$("#ref-form").hide();
	$("#enter-ref").click(function(e) { e.preventDefault(); $("#ref-form").toggle(); });
});
</script>


<? if ($singles) : ?>
<h2>Single Codes</h2>

<table class="table table-striped">
<thead>
<tr><th>&nbsp;</th><th>Time</th><th>Code</th><th>Device</th></tr>
</thead>
<tbody>
<? foreach ($singles as $i => $code) : ?>
<tr>
<td><span class="row-number"><?=$i+1?></span></td>
<td><?=date("M d, Y - H:i", strtotime($code->time))?></td>
<td><?=$code->code?></td>
<td><?=$code->device->name?></td>
</tr>
<? endforeach ?>
</tbody>
<tfoot>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
</tfoot>
</table>

<? endif ?>

<? if ($pairs) : ?>
<h2>Start / End Codes</h2>

<table class="table table-striped">
<thead>
<tr><th>&nbsp;</th><th>Start Time</th><th>End Time</th><th>Start Code</th><th>End Code</th><th>Device</th><th>Duration</th></tr>
</thead>
<tbody>
<? foreach ($pairs as $i => $code) : ?>
<tr>
<td><span class="row-number"><?=$i+1?></span></td>
<td><?=date("M d, Y - H:i", strtotime($code->time))?></td>
<td><?=date("M d, Y - H:i", strtotime($code->end_time))?></td>
<td><?=$code->code?></td>
<td><?=$code->end_code?></td>
<td><?=$code->device->name?></td>
<td><?=timespan(0, $code->duration)?></td>
</tr>
<? endforeach ?>
</tbody>
<tfoot>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><strong>Total Duration</strong></td><td><?=$total_time?></td></tr>
</tfoot>
</table>

<p>This time/date has been verified by Clockinpoint.</p>
<? endif ?>
 
<div class="form-actions">
<a href="<?php echo site_url(); ?>clients/codes/pdf/summary/<?=$batch_ref?>" class="btn btn-success btn-large"><i class="icon-file icon-white"></i> Download PDF</a> <a class="btn btn-success btn-large" href="<?php echo site_url();?>clients/codes/">Enter More Codes</a> <a href="<?php echo site_url(); ?>clients/codes/options" class="btn btn-success btn-large">Submit</a>
</div>

</div>