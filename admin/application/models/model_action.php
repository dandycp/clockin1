<?php 

class Model_Action extends MY_Bean
{
	
	public function after_update()
	{
		// by default, add any new actions as permission for the default (admin) usergroup
		if (!R::findOne('permission', "action_id=?", array($this->id))) {
			$permission = R::dispense('permission');
			$permission->action = $this;
			$permission->usergroup_id = 1;
			R::store($permission);
		}
	}
	
}