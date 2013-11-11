<?php 

class Users extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		//$this->output->enable_profiler(TRUE);
	}
	function index()
	{
		$this->auth->action('list', 'user');
		
		$usergroups = $this->user->ownUsergroup;
		$users = array();
		if ($usergroups) foreach ($usergroups as $usergroup) {
			$users = array_merge($users, array_values($usergroup->ownUser));
		}
		$title = 'Users';
		$this->load->view('users/list', compact('users','usergroups','title'));
	}
	
	
	function add()
	{
		$this->auth->action('add', 'user');
		
		$error = false;
		$usergroups = $this->user->ownUsergroup;
		$user = R::dispense('user');
		$user->account_id = $this->account->id;
		
		if ($data = $this->input->post()) {
			try {
				$user->import($data, 'first_name,last_name,tel,usergroup_id,email,password,manager.dept');
				R::store($user);	
				
				$this->session->set_flashdata('message', 'User added successfully.');
				redirect('/users');
			} catch (Exception $e) {
				$error = $e->getMessage();
			}
		}
		$title = 'Add User';
		$this->load->view('users/add', compact('error','user','usergroups','title'));
	}
	
	function edit($id)
	{
		$this->auth->action('edit', 'user');
		
		$error = false;
		$usergroups = $this->user->ownUsergroup;
		$user = R::load('user', $id);
		if (!$user) show_404();
		
		// todo - check they have permission to do this edit!
		
		// make sure people can't edit their own usergroup
		$can_edit_usergroup = ($this->user->id != $user->id) ? true : false ;
		
		if ($data = $this->input->post()) {
			try {
				$user->import($data, 'title,first_name,last_name,tel,usergroup_id,email,manager.dept');
				// only update password if they've entered something
				if (!empty($data['password'])) $user->password = $data['password'];
				R::store($user);	
				
				$this->session->set_flashdata('message', 'User successfully updated.');
				redirect('/users');
			} catch (Exception $e) {
				$error = $e->getMessage();
			}
		}
		$title ='Edit';
		$this->load->view('users/edit', compact('error','user','usergroups','can_edit_usergroup','title'));
	}
	
	
	function edit_profile()
	{
		$this->load->view('users/edit-profile');
	}
	
	function delete($id)
	{
		$this->auth->action('delete', 'user');
		
		$error = false;
		if (!$id) redirect('/users');
		$user = R::load('user', $id);
		if (!$user) show_404();
		
		// check for safety that this group is owned by our user!
		// todo - finish off if ($user->usergroup->user_id != $this->user->id) show_404();
		
		if ($data = $this->input->post()) {
			
			try {
				
				R::trash($user);
				
				$this->session->set_flashdata('message', 'User successfully deleted');
				redirect('/users');
				
			} catch (Exception $e) {
				$error = $e->getMessage();	
			}
		}
		$this->load->view('users/delete', compact('user','error'));
	}

}