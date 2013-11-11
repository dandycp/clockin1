<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages_model extends MY_Model {

	
	var $primary_table = 'pages';
	var $primary_key = 'id';
    var $validate_field_existence = TRUE;

    var $fields = array(
        'id', 	
        'title', 	
        'description', 	
        'content', 	
        'visible', 	
        'status', 	
        'slug ',	
        'image'
    );

    var $required_fields = array(
        'title', 	
        'description', 	
        'content', 	
        'visible', 	
        'status', 	
        'slug '
    );
    // Returns all pages
    function getAll()
    {
    	$data = array();

    	$this->db->select('*');
    	//$this->db->where('status', '1');

    	$Q = $this->db->get('pages');

    	if ($Q->num_rows() > 0){
	      $data = $Q->result_array();
	    }
		
	    $Q->free_result();    
	    return $data;
    }

    function getAllbyID($id)
    {
        $data = array();
        $options = array('id' => $id);
        $Q = $this->db->get_where('pages',$options,1);
        if ($Q->num_rows() > 0){
          $data = $Q->row_array();
        }

        $Q->free_result();    
        return $data;
    }

    // Create Page
    function create_new_page()
    {
        $options = array(
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'content' => $this->input->post('content'),
            'slug' => url_title($this->input->post('slug'), '-', TRUE),
            'status' => $this->input->post('status')
        );
        $this->db->insert('pages',$options);
        $this->session->set_flashdata('alert_success', 'Success<br />Page created and saved.');
        redirect('cms/pages');
    }

    // Edit Page
    function edit_page($id)
    {
        $id = $this->uri->segment(3);
        $options = array(
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'content' => $this->input->post('content'),
            'slug' => url_title($this->input->post('slug'), '-', TRUE),
            'status' => $this->input->post('status')
        );
        $this->db->where('id', $id);
        $this->db->update('pages', $options); 
        $this->session->set_flashdata('alert_success', 'Page successfully updated.');
        redirect('cms/pages');
    }

    // Delete Page
    function delete_page($id)
    {
        $this->db->delete('pages', array('id' => $id)); 
        $this->session->set_flashdata('alert_success', 'Page successfully removed.');
        redirect('cms/pages');
    }

}
/* End of file pages_model.php */
/* Location: ./application/models/pages_model.php */