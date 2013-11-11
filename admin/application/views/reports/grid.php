
<? if ($codes) : ?>

<div class="form-group">
     <label class="sr-only">Unique Reference</label>
    <div class="col-lg-3">
      <input type="text" class="form-control" name="uid" id="uid" placeholder="* Unique Ref">
      <span class="help-inline">* must be 10 characters</span>
    </div>
  </div>

<table class="table table-striped datatable client-report table-condensed">
<thead>
<tr>
	<th><!--row number--></th>
	
	<? if ($is_provider) : ?>
		<th>Client<br />
		<select class="select-filter form-control"></select></th>
	<? endif ?>
	
	<? if ($is_pair) : ?>
		<th>Start Time<br />
		<input type="text" class="input-filter form-control" /></th>
		<th>Start Code<br />
		<input type="text" class="input-filter form-control" /></th>
		
		<th>End Time<br />
		<input type="text" class="input-filter form-control" /></th>
		<th>End Code<br />
		<input type="text" class="input-filter form-control" /></th>
	<? else : ?>
		<th>Date &amp; Time<br />
		<input type="text" class="input-filter form-control" /></th>
		<th>Code<br />
		<input type="text" class="input-filter form-control" /></th>
	<? endif ?>
	
	<th class="initially-hidden">Batch Ref<br />
	<input type="text" class="form-control"/></th>
	
	<th>Device<br />
	<select class="select-filter form-control"></select></th>
	
	<th class="initially-hidden">Address<br />
	<input type="text" class="input-filter form-control"></th>
	
	<th class="initially-hidden">Location<br />
	<input type="text" class="input-filter form-control"></th>
	
	<th>Entered By<br />
	<select class="select-filter form-control"></select></th>
	
	<th class="initially-hidden">Usergroup<br />
	<select class="select-filter form-control"></select></th>
	
	<th class="initially-hidden">Person<br />
	<select class="select-filter form-control"></select></th>
	
	<th class="initially-hidden">Category<br />
	<select class="select-filter form-control"></select></th>
	
	<th>Entered On<br />
	<input type="text" class="input-filter form-control" /></th>
	
	<? if ($is_pair) : ?>
		<th>Duration</th>
	<? endif ?>
	
	<? if ($this->account->uses_custom_1()) : ?>
	<th class="initially-hidden"><?=$this->account->custom_1_name?><br />
	<input type="text" class="input-filter form-control" /></th>
	<? endif ?>
	
	<? if ($this->account->uses_custom_2()) : ?>
	<th class="initially-hidden"><?=$this->account->custom_2_name?><br />
	<input type="text" class="input-filter form-control" /></th>
	<? endif ?>
	
</tr>
</thead>
<tbody>
<? foreach ($codes as $i => $code) : ?>
<tr>
<td><!--row number--><span class="row-number"><?=$i+1?></span></td>

<? if ($is_provider) : ?>
	<td><?=$code->account->name()?></td>
<? endif ?>

<td><?=date("M d, Y - H:i", strtotime($code->time))?></td>
<td><?=$code->code?></td>

<? if ($is_pair) : ?>
	<td><?=date("M d, Y - H:i", strtotime($code->end_time))?></td>
	<td><?=$code->end_code?></td>
<? endif ?>

<td><?=$code->batch_ref?></td>

<td class="device-name"><?=$code->device->name?></td>

<!--<td><?=$code->device->address->full_address()?></td>-->

<td><?=$code->device->location?></td>

<td><?=$code->fetchAs('user')->inputter->name?></td>

<td><?=$code->fetchAs('user')->inputter->usergroup->name?></td>

<td><?=$code->person_name()?></td>
<td><?=$code->category_name()?></td>
<td><?=date("M d, Y - H:i", strtotime($code->added_at))?></td>

<? if ($is_pair) : ?>
	<td><?=timespan(0, $code->duration)?></td>
<? endif ?>

<? if ($this->account->uses_custom_1()) : ?>
	<td><?=$code->custom_1?></td>
<? endif ?>	

<? if ($this->account->uses_custom_2()) : ?>
	<td><?=$code->custom_2?></td>
<? endif ?>	

</tr>
<? endforeach ?>
</tbody>

<? if ($is_pair) : ?>
	<tfoot>
	<tr>
	<? if ($is_provider) : ?>
		<th> </th>
	<? endif ?>
	<th> </th><th> </th><th> </th><th> </th><th> </th><th> </th><th> </th><th> </th><th> </th><th> </th><th> </th><th> </th><th> </th><th> </th><th><?=$total_time?></th>
	
	<? if ($this->account->uses_custom_1()) : ?>
	<th> </th>
	<? endif ?>	

	<? if ($this->account->uses_custom_2()) : ?>
	<th> </th>
	<? endif ?>	
	
	</tr>
	</tfoot>
<? endif ?>

</table>

<form id="pdf_form" action="pdf/report" method="post" target="_blank">
<input type="hidden" name="html" value="" id="pdf_html" />
<button id="pdf_btn" class="btn btn-primary">PDF</button>
</form>

<form action="" method="post">
	<input type="hidden" name="html" value="" id="pdf_html" />
	<button id="pdf_btn" class="btn btn-mini"><i class="icon-hdd"></i> Save Report</button>
</form>

<? else : ?>
<div class="alert"><strong>Notice: </strong>No codes found for this period.</div>
<? endif ?>