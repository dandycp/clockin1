<?php 

class Permissions extends MY_Controller
{
	
	function index()
	{
		$this->auth->action('list', 'permission');
		
		$entities = R::find('entity');
		$default_permissions = R::find('permission', "usergroup_id = 1");
		$this->load->view('permissions/list', compact('entities','default_permissions'));	
	}
	
	function add_action($entity_id)
	{
		$this->auth->action('add_action', 'permission');
		
		$error = false;
		$action = R::dispense('action');
		$entity = R::load('entity', $entity_id);
		
		if (!$entity) show_404();
		
		if ($data = $this->input->post()) {
			try {
				
				$action->import($data, 'name');
				$action->entity_id = $entity_id;
				R::store($action);
				
				$this->session->set_flashdata('message', 'Action added successfully.');
				redirect('/permissions');
			} catch (Exception $e) {
				$error = $e->getMessage();
			}
		}
		
		$this->load->view('permissions/add_action', compact('error','action','entity'));
	}
	
	
	function delete_action($action_id)
	{
		$this->auth->action('delete_action', 'permission');
		
		$error = false;
		if (!$action_id) redirect('/permissions');
		$action = R::load('action', $action_id);
		if (!$action) show_404();
		
		$permissions = R::find('permission', "action_id = ?", array($action_id));
		
		if ($data = $this->input->post()) {
			
			try {
				
				R::trash($action);
				
				$this->session->set_flashdata('message', 'Action successfully deleted');
				redirect('/permissions');
				
			} catch (Exception $e) {
				$error = $e->getMessage();	
			}
		}
		$this->load->view('permissions/delete_action', compact('action','permissions','error'));
	}
	
	
	function add_entity()
	{
		$this->auth->action('add_entity', 'permission');
		
		$error = false;
		if ($data = $this->input->post()) {
			try {
				
				$entity = R::dispense('entity');
				$entity->import($data, 'name,ref');
				R::store($entity);
				
				$this->session->set_flashdata('message', 'Entity added successfully.');
				redirect('/permissions');
			} catch (Exception $e) {
				$error = $e->getMessage();
			}
		}
		
		$this->load->view('permissions/add_entity', compact('error','entity'));
	}
	
	function delete_entity($entity_id)
	{
		$this->auth->action('delete_entity', 'permission');
		
		$error = false;
		if (!$entity_id) show_404();
		$entity = R::load('entity', $entity_id);
		if (!$entity) show_404();
		
		if ($data = $this->input->post()) {
			
			try {
				
				R::trash($entity);
				
				$this->session->set_flashdata('message', 'Entity successfully deleted');
				redirect('/permissions');
				
			} catch (Exception $e) {
				$error = $e->getMessage();	
			}
		}
		$this->load->view('permissions/delete_entity', compact('entity','error'));
	}
	
	// add a permission for the default (admins) usergroup
	function add_permission($usergroup_id=false)
	{
		$this->auth->action('add', 'permission');
		
		$error = false;
		$permission = R::dispense('permission');
		if (!$usergroup_id) $usergroup_id = 1;
		$usergroup = R::load('usergroup', $usergroup_id);
		$actions = R::find('action', '1 ORDER BY entity_id');
		
		if (!$usergroup) show_404();
		
		if ($data = $this->input->post()) {
			try {
				
				$permission->import($data, 'action_id');
				$permission->usergroup_id = $usergroup_id;
				R::store($permission);
				
				$this->session->set_flashdata('message', 'Permssion added successfully.');
				redirect('/permissions');
			} catch (Exception $e) {
				$error = $e->getMessage();
			}
		}
		
		$this->load->view('permissions/add_permission', compact('error','permission','usergroup','actions'));
	}
	
	function delete_permission($permission_id)
	{
		$this->auth->action('delete', 'permission');
		
		$error = false;
		if (!$permission_id) redirect('/permissions');
		$permission = R::load('permission', $permission_id);
		if (!$permission) show_404();
		
		if ($data = $this->input->post()) {
			
			try {
				
				R::trash($permission);
				
				$this->session->set_flashdata('message', 'Permission successfully deleted');
				redirect('/permissions');
				
			} catch (Exception $e) {
				$error = $e->getMessage();	
			}
		}
		$this->load->view('permissions/delete_permission', compact('permission','error'));
	}

}