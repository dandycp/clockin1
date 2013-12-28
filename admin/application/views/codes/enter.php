
<h2>Enter codes</h2>
<div class="well lead">Use when both a start and end code have been recorded per visit/session.</div>

<? if ($error) : ?>
	<div class="alert alert-danger"><strong>Oops ... Sorry!</strong><br /><?=$error?></div>
<? endif ?>

	<div class="pull-left" style="width: 1120px;">
		<form action="" method="post" class="form-inline" role="form">
<!--
		<? if (!empty($clients)) : ?>
		<div class="control-group">
			<label class="control-label">Codes for different clients must be entered seperately. Please choose which client you wish to enter codes for:</label>
			<div class="controls">
				<select name="client_id" id="client_id" class="form-control" maxlength="15" width="15">
				<option value="">Please select client...</option>
				<? foreach ($clients as $client) : ?>
				<option value="<?=$client->id?>"><?=$client->name()?></option>
				<? endforeach ?>
				</select>
				
			</div>
		</div>
		<? endif ?>


		
		<div class="control-group">
			<? if (!empty($people)) : ?>
			<label class="control-label">Default Person</label>
				<select name="default_person_id" id="default_person_id" class="form-control" maxlength="15" width="15">
					<option value="">- none -</option>
					<? if ($people) foreach ($people as $person) : ?>
					<option value="<?=$person->id?>"><?=$person->name?></option>
					<? endforeach ?>
				</select>
			<? endif ?>

			&nbsp;&nbsp;

			<? if (!empty($providers)) : ?>
			
				<label class="control-label">Default Provider:</label>
					<select name="default_provider_id" id="default_provider_id" class="form-control">
					<option value=""> - none - these are my own</option>
					<? foreach ($providers as $provider) : ?>
					<option value="<?=$provider->id?>"><?=$provider->name()?></option>
					<? endforeach ?>
				</select>
			<? endif ?>

			&nbsp;&nbsp;

			<? if (!empty($categories)) : ?>
	
			<label class="control-label">Default Category</label>
			
				<select name="default_category_id" id="default_category_id" class="form-control" maxlength="15" width="15">
				<option value="">- none -</option>
				<option value="23">General Works</option>
				<? if ($categories) foreach ($categories as $category) : ?>
				<option value="<?=$category->id?>"><?=$category->name?></option>
				<? endforeach ?>
				</select>
			
		

		<? endif ?>

		</div>
	-->
		
		
		<div class="row heading-row">
			<div class="span3" style="margin-right: 9px !important; ">Start Code</div>
			<div class="span3" style="margin-right: 9px !important; ">End Code</div>
			<? if ($providers) : ?>
			<div class="span3">Provider</div>
			<? endif ?>

			<div class="span3">Works Staff</div>
			<div class="span2">Category</div>
		</div>
	
		
		<div class="codes-container">
            <div class="code-row">
		<div class="row">
			
		
			<div class="span3 control-group" style="margin-right: 8px !important; ">
				<input type="text" maxlength="8" width="8" class="code start-code inline form-control" data-type="start_codes" name="pairs[0][start]" autofocus>
				
			</div>
			&nbsp;&nbsp;
			<div class="span3 control-group" style="margin-right: 8px !important; ">
				<input type="text" maxlength="8" width="8" class="code end-code inline form-control" data-type="end_codes" name="pairs[0][end]">
				
			</div>
			
			<? if ($providers) : ?>
			<div class="span3 control-group">
				<select name="pairs[0][provider_id]" class="provider_id form-control">
					<option value=""> - </option>
					<? foreach ($providers as $provider) : ?>
					<option value="<?=$provider->id?>"><?=$provider->name()?></option>
					<? endforeach ?>
				</select>
			</div>
			<? endif ?>
			
			<div class="span3 control-group">
				<select name="pairs[0][person_id]" class="person_id form-control">
					<?php if ($this->session->userdata('is_logged_in')){?><option value=""><?php echo $this->session->userdata('first_name'); ?></option><?php } ?>
					<? if ($people) foreach ($people as $person) : ?>
					<option value="<?=$person->id?>"><?=$person->name?></option>
					<? endforeach ?>
				</select>
			</div>
			
			<div class="span3 control-group">
				<select name="pairs[0][category_id]" class="category_id form-control">
					<option value=""> - </option>
					<option value="23">General Works</option>
					<? if ($categories) foreach ($categories as $category) : ?>
					<option value="<?=$category->id?>"><?=$category->name?></option>
					<? endforeach ?>
				</select>
			</div>
		
			<div class="span1">
				<a class="add-btn"><img src="<?php echo site_url(); ?>images/add.png" width="16" height="16"></a> 
				<a class="delete-btn" style="display:none;"><img src="<?php echo site_url(); ?>images/delete.png" width="16" height="16"></a>
			</div>

		</div><!--  end first .row -->
        <div class="row">
            <div class="span3">
                <div class="help-block start"></div>
            </div>
            <div class="span3">
                <div class="help-block end"></div>
            </div>
            <div class="span3">
                <div class="duration"></div>
            </div>
        </div><!-- end second .row -->
		<div style="clear:both; height: 5px;"></div>
            </div><!-- end .code-row -->
            </div><!-- end .codes-container -->
		<div class="form-group" style="margin: 3px 0px 4px 0px;">
			<button type="submit" class="btn btn-success btn-large">Confirm</button>
		</div>
</form>
	</div> <!--end .pull-left -->

<script src="<?php echo site_url(); ?>js/jquery.autotab-1.1b.js"></script>
<script src="<?php echo site_url(); ?>js/code-entry.js"></script>