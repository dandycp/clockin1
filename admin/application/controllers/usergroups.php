<?php 

class Usergroups extends MY_Controller
{
	function add()
	{
		$this->auth->action('add', 'usergroup');
		
		$error = false;
		$usergroup = R::dispense('usergroup');
		$current_usergroup = $this->user->usergroup;
		
		// get all the entities that this user currently has access to
		// to provide the basis for what they can assign to other users
		$actions = $this->user->usergroup->get_actions();
		$permissions = array();
		
		if ($data = $this->input->post()) {
			try {
				
				$usergroup->import($data, 'name');
				$usergroup->user_id = $this->user->id;
				
				$permissions = $data['permissions'];
				if (!empty($permissions)) {
					foreach ($permissions as $action_id => $action_id) {
						if (!empty($action_id)) {
							$permission = R::dispense('permission');
							$permission->action_id = $action_id;
							$usergroup->ownPermission[] = $permission;
						}
					}
				}
				
				R::store($usergroup);
				
				$this->session->set_flashdata('message', 'User Group added successfully.');
				redirect('/users');
			} catch (Exception $e) {
				$error = $e->getMessage();
			}
		}
		$title = 'Add Usergroup';
		$this->load->view('usergroups/add', compact('error','usergroup','actions','permissions','title'));
	}
	
	function edit($id)
	{
		$this->auth->action('edit', 'usergroup');
		
		$error = false;
		$usergroup = R::load('usergroup', $id);
		if (!$usergroup->id) show_404();
		
		// get all the actions available to the *current* user's usergroup
		$actions = $this->user->usergroup->get_actions();
		
		// get the permissions for the usergroup that we're editing
		$permissions = $usergroup->get_permissions();
		
		if ($data = $this->input->post()) {
			try {
				$usergroup->import($data, 'name');
				
				// remove old permissions first in one go because it's easier
				$current_permissions = $usergroup->ownPermission;
				R::trashAll($current_permissions);
				
				// reload the usergroup so that we can apply the new permissions
				// todo - see if there is a built in 'refresh' method for redbean
				$usergroup = R::load('usergroup', $id);
				
				$permissions = $data['permissions'];
				
				if (!empty($permissions)) {
					foreach ($permissions as $action_id => $action_id) {
						if (!empty($action_id)) {
							// todo - check that they actually have permission to assign this action_id and entity_id
							$permission = R::dispense('permission');
							$permission->action_id = (int) $action_id;
							$usergroup->ownPermission[] = $permission;
						}
					}
				}
				
				R::store($usergroup);	
				
				$this->session->set_flashdata('message', 'User Group edited successfully.');
				redirect('/users');
			} catch (Exception $e) {
				$error = $e->getMessage();
			}
		}
		
		$this->load->view('usergroups/edit', compact('error','usergroup','actions','permissions'));
	}
	
	function delete($id)
	{
		$this->auth->action('delete', 'usergroup');
		
		$error = false;
		if (!$id) redirect('/users');
		$usergroup = R::load('usergroup', $id);
		if (!$usergroup) show_404();
		
		// check for safety that this group is owned by our user!
		if ($usergroup->user_id != $this->user->id) show_404();
		
		if ($data = $this->input->post()) {
			
			try {
				
				// check if any users assigned to this group and halt if so
				$users = $usergroup->ownUser;
				if ($users) throw new Exception('You still have users who are assigned to this group');
				
				R::trash($usergroup);
				
				$this->session->set_flashdata('message', 'User Group successfully deleted');
				redirect('/users');
				
			} catch (Exception $e) {
				$error = $e->getMessage();	
			}
		}
		$this->load->view('usergroups/delete', compact('usergroup','error'));
	}

}