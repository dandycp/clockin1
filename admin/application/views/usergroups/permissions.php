<fieldset>
	
	<legend>Permissions</legend>
	<? if ($actions) : ?>
	<table class="table table-striped">
	<thead>
	<tr><th>Entity</th><th>Action</th></tr>
	</thead>
	
	<tbody>
	
	<? foreach ($actions as $entity) : ?>
	
	<tr>
	<td><?=ucwords($entity['name'])?></td>
	<td>
	<? foreach ($entity['actions'] as $action) : ?>
	<label class="checkbox inline">
	<input name="permissions[<?=$action->id?>]" type="checkbox" value="<?=$action->id?>" <? if (isset($permissions[$action->id])) echo 'checked="checked"' ?>> 
	<?=$action->name?>
	</label>
	<? endforeach ?>
	</td>
	</tr>
	
	<? endforeach ?>
	</tbody>
	</table>
	<? else : ?>
	<div class="alert">No permissions can be assigned to this User Group</div>
	<? endif ?>
</fieldset>