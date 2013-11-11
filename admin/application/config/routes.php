<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "clients";
$route['404_override'] = 'errors/error_404';

/* CUSTOM ROUTES
* Set all custom routes here
*/

$route['clients/reports'] 						= 'reports/index';
$route['clients/codes'] 						= 'codes/index';
$route['clients/notifications']					= 'account/notifications';
$route['clients/send_to_friend']				= 'clients/send_to_friend';
$route['clients/devices/device_search']	        = 'devices/device_search';

/* Device Routes */
$route['clients/devices']						= 'devices';
$route['clients/devices/check/(:any)'] 			= 'devices/check/$1';
$route['clients/devices/add'] 					= 'devices/add';
$route['clients/devices/edit/(:num)'] 			= 'devices/edit/$1';
$route['clients/devices/calibrate/(:any)'] 		= 'devices/calibrate/$1';
$route['clients/devices/calibration_complete']  = 'devices/calibration_complete';
$route['clients/devices/delete/(:num)']			= 'devices/delete/$1';
$route['clients/devices/calibrate_error']		= 'devices/calibrate_error';
$route['clients/devices/get_reg_string/(:num)']	= 'devices/get_reg_string/$1';
$route['clients/devices/calibration_complete']  = 'devices/calibration_complete';
$route['clients/devices/update_offset/(:any)']	= 'devices/update_offset/$1';
$route['clients/devices/checked/(:any)']	    = 'devices/checked/$1';
$route['clients/devices/export']				= 'devices/export';
$route['clients/devices/upload_step_1']			= 'devices/upload_step_1';
$route['clients/devices/do_upload']			    = 'devices/do_upload';
$route['clients/devices/upload_complete']		= 'devices/upload_complete';
$route['clients/devices/records_matched']		= 'devices/records_matched';
$route['clients/devices/group_device']			= 'devices/group_device';
$route['clients/devices/delete_group/(:any)']   = 'devices/delete_group/$1';
$route['clients/devices/run_report/(:any)']		= 'devices/run_report/$1';

/* Customer Routes */
$route['clients/customers']						= 'customers/index';
$route['clients/customers/add']					= 'customers/add';
$route['clients/customers/approve']				= 'customers/approve';
$route['clients/customers/delete/(:num)']		= 'customers/delete/$1';

/* Providers Routes */
$route['clients/providers']						= 'providers/index';
$route['clients/providers/delete/(:num)']		= 'providers/delete/$1';
$route['clients/providers/approve/(:any)']		= 'providers/approve/$1';
$route['clients/providers/add']					= 'providers/add';
$route['clients/providers/reject/(:any)']	    = 'providers/reject/$1';
$route['clients/providers/edit/(:any)']			= 'providers/edit/$1';
$route['clients/providers/send_email']			= 'providers/send_email';

/* User & Usergroups */
$route['clients/usergroups/add']				= 'usergroups/add';
$route['clients/usergroups']					= 'usergroups/add';
$route['clients/users'] 						= 'users';
$route['clients/users/add']						= 'users/add';
$route['clients/usergroups/edit/(:any)']		= 'usergroups/edit/$1';
$route['clients/users/edit/(:any)']				= 'users/edit/$1';

$route['clients/account/users/edit/(:any)']		= 'account/users/edit/$1';

$route['clients/account/change_package'] 		= 'account/change_package';
$route['clients/payments/add_card']				= 'payments/add_card';

/* People Routes */
$route['clients/people']						= 'people';
$route['clients/people/add']					= 'people/add';
$route['clients/people/edit/(:any)']			= 'people/edit/$1';
$route['clients/people/delete/(:any)']			= 'people/delete/$1';
$route['clients/people/upload']					= 'people/upload';
$route['clients/people/upload_complete']		= 'people/upload_complete';
$route['clients/people/export']					= 'people/export';

/* Codes Routes */
$route['clients/codes']							= 'codes/index';
$route['clients/codes/finder']					= 'codes/finder';
$route['clients/codes/save_code']				= 'codes/save_code';
$route['clients/codes/summary']					= 'codes/summary';
$route['clients/codes/validate/(:any)']			= 'codes/validate/$1';
$route['clients/codes/generate_batch_reference']= 'codes/generate_batch_reference';
$route['clients/codes/update_batch_ref']		= 'codes/update_batch_ref';
$route['clients/codes/generate']				= 'codes/generate';
$route['clients/codes/pdf/summary/(:any)']      = 'pdf/summary/$1';
$route['clients/codes/pdf/report']				= 'pdf/report';


$route['clients/reports/list_all']				= 'reports/list_all';
$route['clients/reports/page/(:any)']				= 'reports/$1';
$route['clients/account/edit']					= 'account/edit';


/* Categories/Work Desc Routes */
$route['clients/categories']					= 'categories';
$route['clients/categories/add']				= 'categories/add';
$route['clients/categories/edit/(:any)']		= 'categories/edit/$1';
$route['clients/categories/delete/(:any)']		= 'categories/delete/$1';

$route['clients/create_account'] 				= 'clients/create_account';
$route['client/add']							= 'clients/add';

/* Invoicing */
$route['clients/invoices']						= 'invoice/index';
$route['clients/view_invoice/(:any)']			= 'invoice/view_invoice/$1';







/* End of file routes.php */
/* Location: ./application/config/routes.php */