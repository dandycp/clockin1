<?php  
 
function add_header_footer_client()
{
	$CI =& get_instance();
	$content = $CI->output->get_output();
	$header = $CI->load->view('clients/header', null, true);
	$footer = $CI->load->view('clients/footer', null, true);
	$CI->output->set_output($header . $content . $footer);
	$CI->output->_display();
}


/* End of file display_override.php */
/* Location: ./system/application/hooks/display_override.php */