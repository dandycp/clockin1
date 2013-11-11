<?php 

class People extends MY_Controller
{
	function index()
	{
		$this->auth->action('list', 'people');
		$people = $this->account->get_people();
		$title = 'People';
		$this->load->view('people/list', compact('people','title'));
	}
	
	
	function add()
	{
		$this->load->library('form_validation');
		$this->auth->action('add', 'people');
		$error = false;
		$person = R::dispense('person');
		//$person->account_id = $this->account->id;

		$this->form_validation->set_rules('name','Name','required|trim');
		$this->form_validation->set_rules('dept','Manager/Department','required|trim');

		if ($this->form_validation->run() == FALSE) {
			//echo '<div class="alert alert-error">'.validation_errors().'</div>';
			//echo validation_errors('<div class="alert alert-error">', '</div>');

		}
		else {
			// Submit to db
			$name = $this->input->post('name');
			$dept = $this->input->post('dept');

			$data = array(
			   'name' => $name,
			   'dept' => $dept,
			   'account_id' => $this->account->id
			);

			$this->db->insert('person', $data); 
			$this->session->set_flashdata('message', 'Person added successfully.');
			redirect('/people');
		}
		
		/*
		if ($data = $this->input->post()) {

			//if (empty($data['name'])) throw new Exception('Persons name is required.');
				
			try {
				$person->import($data, 'name','dept');
				R::store($person);	
				
				$this->session->set_flashdata('message', 'Person added successfully.');
				redirect('/people');
			} catch (Exception $e) {
				$error = $e->getMessage();
			}
		}
		*/
		$title = 'Add New Person';
		$this->load->view('people/add', compact('error','person','title'));
	}
	
	function edit($id)
	{
		$this->auth->action('edit', 'people');
		$error = false;
		$person = R::load('person', $id);
		if (!$person) show_404();
		if ($person->account_id != $this->account->id) $this->auth->access_restricted();
		
		$this->form_validation->set_rules('name','Name','required|trim');
		$this->form_validation->set_rules('dept','Manager/Department','required|trim');

		if ($this->form_validation->run() == FALSE) {
			//echo '<div class="alert alert-error">'.validation_errors().'</div>';
			//echo validation_errors('<div class="alert alert-error">', '</div>');

		}
		else {
			// Submit to db
			$name = $this->input->post('name');
			$dept = $this->input->post('dept');

			$data = array(
			   'name' => $name,
			   'dept' => $dept
			);

			
			$this->db->where('account_id', $person->account_id);
			$this->db->update('person', $data); 
			$this->session->set_flashdata('message', 'Person updated successfully.');
			redirect('/people');
		}

		/*
		if ($data = $this->input->post()) {
			try {
				$person->import($data, 'name','dept');
				R::store($person);	
				$this->session->set_flashdata('message', 'Person successfully updated.');
				redirect('/people');
			} catch (Exception $e) {
				$error = $e->getMessage();
			}
		}
		*/
		$title = 'Edit Person';
		$this->load->view('people/edit', compact('error','person','title'));
	}
	
	function delete($id)
	{
		$this->auth->action('delete', 'people');
		$error = false;
		if (!$id) redirect('/people');
		$person = R::load('person', $id);
		if (!$person) show_404();
		
		if ($person->account_id != $this->account->id) $this->auth->access_restricted();
		
		if ($data = $this->input->post()) {
			
			try {
				
				$person->active = 0;
				R::store($person);
				
				$this->session->set_flashdata('message', 'Person successfully deleted');
				redirect('/people');
				
			} catch (Exception $e) {
				$error = $e->getMessage();	
			}
		}
		$title = 'Delete Person';
		$this->load->view('people/delete', compact('person','error','title'));
	}
	public function export(){
		$this->load->helper('download');
    	$this->load->dbutil();
    	$account_id = $this->session->userdata('account_id');
    	
    	$Q = $this->db->query("SELECT name, dept, account_id FROM person WHERE account_id = $account_id LIMIT 0 , 10");
    	$csv_return = $this->dbutil->csv_from_result($Q,",","\n");
		force_download('People_MultiUpload -'.$account_id.'.csv', $csv_return); 
 	}
	public function upload()
	{
		$account_id = $this->session->userdata('account_id');
		$csv_path = realpath(APPPATH . '/../assets/uploads/');
		$config['upload_path']   = $csv_path;
		$config['allowed_types'] = '*'; // All types of files allowed
		$config['overwrite']     = true; // Overwrites the existing file
		  
		$this->upload->initialize($config);
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('userfile'))
		{
			$error = $this->upload->display_errors();
			$title = "There was an error";
			$this->load->view('people/upload', compact('error','title'));
		}
		else
		{
			$table = 'person';
			$image_data = $this->upload->data();
    		$fname = $image_data['file_name'];
    		$fpath = $image_data['file_path'].$fname;
    		$fh = fopen($fpath, "r+");
    		$headers = 0;
			
			$insert_str = 'INSERT INTO person (name, dept, account_id) VALUES '."\n";
			

			if ($fh && $headers == 0) {
	            // Create each set of values.
	            while (($csv_row = fgetcsv($fh, 1000, ',')) !== false) {

	                foreach ($csv_row as &$row) {
	                    $row = strtr($row, array("'" => "\\'", '"' => '\\"'));
	                }

	                $insert_str .= '("'
	                    // Implode the array and fix pesky apostrophes.
	                    .implode('","', $csv_row)
	                    .'"),'."\n";
	            
	            }

	            // Remove the trailing comma.
	            $insert_str = rtrim($insert_str, ",\n");

	            // Insert all of the values at once.
	            $this->db->query($insert_str);
		        $title = 'Upload File';
	            $this->load->view('people/upload_complete', compact('title'));
			
	        } 		
		}
	}

}