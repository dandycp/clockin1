<?php 

class Model_Usergroup extends MY_Bean 
{
	public function update() 
	{
		if (empty($this->name)) throw new Exception('Name is required');
		if (empty($this->user_id)) throw new Exception('User/Owner is required');
	}
	
	// return all the available actions for this usergroup
	public function get_actions()
	{
		$actions = array();
		$permissions = $this->ownPermission;
		if ($permissions) foreach ($permissions as $permission) {
			$action = $permission->action;
			$entity = $action->entity;
			$actions[$entity->id]['name'] = $entity->name;
			$actions[$entity->id]['actions'][] = $action;
		}
		return $actions;
	}
	
	public function get_entities()
	{
		$entities = array();
		$permissions = $this->ownPermission;
		if ($permissions) foreach ($permissions as $permission) {
			$entity = $permission->entity;
			if (!in_array($entity->id, $entities))
				$entities[$entity->id] = $entity;
		}
		return $entities;
	}
	
	public function get_permissions()
	{
		$permissions_array = array();
		$permissions = $this->ownPermission;
		if ($permissions) foreach ($permissions as $permission) {
			$action = $permission->action;
			$entity = $action->entity;
			$permissions_array[$action->id] = $action->id;
		}
		return $permissions_array;
	}
}