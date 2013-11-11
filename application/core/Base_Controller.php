<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Base_Controller extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        
        // Set timezome
        date_default_timezone_set('Europe/London');

        // Check if user is logged in or not
        $is_logged_in = $this->session->userdata('is_logged_in');
        $status = $this->session->userdata('status');
        if (!$is_logged_in && $status != 0) {
            redirect('cms/sessions');
            $this->session->set_flashdata('access','Sorry you must be logged in to use this page.');
        }
        
        // Load Languages
        
        
        // Load Libraries
        $this->load->library('form_validation');
        $this->load->library('image_lib');
        $this->load->library('upload');
        $this->load->library('email');

        // Load Helpers        
        $this->load->helper('url');
        $this->load->helper('number');
        $this->load->helper('date');
        $this->load->helper('language');
        $this->load->helper('form');
        $this->load->helper('pager');
        $this->load->helper('html');
        $this->load->helper('text');
        $this->load->helper('file');
        $this->load->helper('string');
        $this->load->helper('security');

        // Load Modules
        $this->load->module('layout');
        $this->load->module('sessions');
        $this->load->module('contact');
        $this->load->module('pages');
        $this->load->module('frontend');
        $this->load->module('site');
            
    }

}

?>