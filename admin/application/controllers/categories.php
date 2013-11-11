<?php 

class Categories extends MY_Controller
{
	function index()
	{
		$this->auth->action('list', 'category');
		$categories = $this->account->get_categories();
		$title = 'Work Descriptions';
		$this->load->view('categories/list', compact('categories','title'));
	}
	
	
	function add()
	{
		$this->auth->action('add', 'category');
		$error = false;
		$category = R::dispense('category');
		$category->account_id = $this->account->id;
		
		if ($data = $this->input->post()) {
			try {
				$category->import($data, 'name, notes');
				R::store($category);	
				
				$this->session->set_flashdata('message', 'Work Description added successfully.');
				redirect('/categories');
			} catch (Exception $e) {
				$error = $e->getMessage();
			}
		}
		$title = 'Add New Work Description';
		$this->load->view('categories/add', compact('error','category','title'));
	}
	
	function edit($id)
	{
		$this->auth->action('edit', 'category');
		$error = false;
		$category = R::load('category', $id);
		if (!$category) show_404();
		if ($category->account_id != $this->account->id) $this->auth->access_restricted();
		
		if ($data = $this->input->post()) {
			try {
				$category->import($data, 'name,notes');
				R::store($category);	
				$this->session->set_flashdata('message', 'Work Description successfully updated.');
				redirect('/categories');
			} catch (Exception $e) {
				$error = $e->getMessage();
			}
		}
		$title = 'Edit Work Description';
		$this->load->view('categories/edit', compact('error','category','title'));
	}
	
	function delete($id)
	{
		$this->auth->action('delete', 'category');
		$error = false;
		if (!$id) redirect('/categories');
		$category = R::load('category', $id);
		if (!$category) show_404();
		
		if ($category->account_id != $this->account->id) $this->auth->access_restricted();
		
		if ($data = $this->input->post()) {
			
			try {
				
				$category->active = 0;
				R::store($category);
				
				$this->session->set_flashdata('message', 'Work Description successfully deleted');
				redirect('/categories');
				
			} catch (Exception $e) {
				$error = $e->getMessage();	
			}
		}
		$title = 'Delete Work Description';
		$this->load->view('categories/delete', compact('category','error','title'));
	}
	
	// return a list of categories for this account
	function get($account_id=0)
	{
		// firstly, check they're logged in
		if (!$this->auth->is_logged_in()) $this->auth->access_restricted();
		
		// check that they 'own' this account
		if ($account_id != $this->account->id) $this->auth->access_restricted();
		
		$result = false;
		$account = R::load('account', $account_id);
		if ($account) {
			$categories = $account->get_categories();
			if ($categories) {
				foreach ($categories as $category) {
					$result[] = array('name'=>$category->name, 'id'=>$category->id);	
				}
			}
		}		
		echo json_encode($result);
		exit;
	}

}