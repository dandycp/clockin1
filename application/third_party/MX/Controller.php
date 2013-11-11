<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/** load the CI class for Modular Extensions **/
require dirname(__FILE__).'/Base.php';

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library replaces the CodeIgniter Controller class
 * and adds features allowing use of modules and the HMVC design pattern.
 *
 * Install this file as application/third_party/MX/Controller.php
 *
 * @copyright	Copyright (c) 2011 Wiredesignz
 * @version 	5.4
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class MX_Controller 
{
	public $autoload = array();
	
	public function __construct() 
	{
		$class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));
		log_message('debug', $class." MX_Controller Initialized");
		Modules::$registry[strtolower($class)] = $this;	
		
		/* copy a loader instance and initialize */
		$this->load = clone load_class('Loader');
		$this->load->initialize($this);	
		
		/* autoload module items */
		$this->load->_autoloader($this->autoload);


		$this->tinyMce = '
				<!-- TinyMCE -->
				<script type="text/javascript" src="'. base_url().'js/tiny_mce/tiny_mce.js"></script>
				<script type="text/javascript" src="'. base_url().'js/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>
				<script type="text/javascript">
						tinyMCE.init({
							mode : "textareas",
							elements : "ajaxfilemanager",
							theme : "advanced",
							   
							width : 800,
							height : 500,
							plugins : "advimage,advlink,media,contextmenu, paste",
							theme_advanced_buttons2_add_before: "cut,copy,separator,",
							theme_advanced_buttons3_add_before : "",
							theme_advanced_buttons3_add : "media,ajaxfilemanager",
							theme_advanced_toolbar_location : "top",
							theme_advanced_toolbar_align : "center",
							extended_valid_elements : "hr[class|width|size|noshade]",
							file_browser_callback : "ajaxfilemanager",
							

							paste_use_dialog : false,
							paste_remove_styles : true,
							paste_remove_spans : true,
							
							paste_auto_cleanup_on_paste : true,

							// Drop lists for link/image/media/template dialogs
        template_external_list_url : "js/template_list.js",
        external_link_list_url : "js/link_list.js",
        external_image_list_url : "js/image_list.js",
        media_external_list_url : "js/media_list.js",


							theme_advanced_resizing : true,
							theme_advanced_resize_horizontal : true,
							apply_source_formatting : true,
							force_br_newlines : true,
							force_p_newlines : false,	
							relative_urls : false,
							document_base_url : "'. base_url() .'",
							urlconvertor_callback: "convLinkVC"
						});
				

					function ajaxfilemanager(field_name, url, type, win) {
						var ajaxfilemanagerurl = "' . base_url() . 'js/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php";
						switch (type) {
							case "image":
								break;
							case "media":
								break;
							case "flash": 
								break;
							case "file":
								break;
							default:
								return false;
						}
			            tinyMCE.activeEditor.windowManager.open({
			                url: "' . base_url() . 'js/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php",
			                width: 800,
			                height: 550,
			                inline : "yes",
			                close_previous : "no"
			            },{
			                window : win,
			                input : field_name
			            });

			            return false;			
						var fileBrowserWindow = new Array();
						fileBrowserWindow["file"] = ajaxfilemanagerurl;
						fileBrowserWindow["title"] = "File Manager";
						fileBrowserWindow["width"] = "782";
						fileBrowserWindow["height"] = "440";
						fileBrowserWindow["close_previous"] = "no";
						tinyMCE.openWindow(fileBrowserWindow, {
						  window : win,
						  input : field_name,
						  resizable : "yes",
						  inline : "yes",
						  editor_id : tinyMCE.getWindowArg("editor_id")
						});

						return false;
					}
					function convLinkVC(strUrl, node, on_save) {
					        strUrl=strUrl.replace("../","../");
					    return strUrl;
					}
				</script>
				<!-- /TinyMCE -->
				';
				$this->gallery_path = realpath(APPPATH . '/../assets/uploads');
				$this->gallery_path_url = base_url().'assets/uploads/';

				$this->slider_path = realpath(APPPATH . '/../assets/uploads/slider');
				$this->slider_path_url = base_url().'uploads/slider/';


				$this->csv_path = realpath(APPPATH . '/../assets/uploads/CSV');
				$this->csv_path_url = base_url().'uploads/CSV/';

	}
	
	public function __get($class) {
		return CI::$APP->$class;
	}
}