<?php
// application/core/MY_Exceptions.php
class MY_Exceptions extends CI_Exceptions {

    public function show_404()
    {
        $CI =& get_instance();
		$CI->output->set_status_header('404');
		$CI->load->view('errors/error_404');
		require_once 'application/hooks/display_override.php';
		add_header_footer_client();
		exit;
    }
}
