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
$route['default_controller'] = 'user/index';
$route['404_override'] = '';

/*admin*/
$route['login'] = 'user/index';
$route['logout'] = 'user/logout';
$route['login/validate_credentials'] = 'user/validate_credentials';

$route['aanganvadi'] = 'admin_aanganvadi/index';
$route['aanganvadi/add'] = 'admin_aanganvadi/add';
$route['aanganvadi/update'] = 'admin_aanganvadi/update';
$route['aanganvadi/fetchTaluko'] = 'admin_aanganvadi/fetchTaluko';
$route['aanganvadi/fetchGaam'] = 'admin_aanganvadi/fetchGaam';
$route['aanganvadi/fetchAanganvadi'] = 'admin_aanganvadi/fetchAanganvadi';
$route['aanganvadi/update/(:any)'] = 'admin_aanganvadi/update/$1';
$route['aanganvadi/delete/(:any)'] = 'admin_aanganvadi/delete/$1';
$route['aanganvadi/(:any)'] = 'admin_aanganvadi/index/$1'; //$1 = page number
$route['kutumb'] = 'admin_kutumb/index';

$route['kutumb'] = 'admin_kutumb/index';
$route['kutumb/addkutumb'] = 'admin_kutumb/addkutumb';
$route['kutumb/update'] = 'admin_kutumb/update';
$route['kutumb/checkvalidation'] = 'admin_kutumb/checkvalidation';
$route['kutumb/printpdf/(:any)'] = 'admin_kutumb/printpdf/$1';
$route['kutumb/update/(:any)'] = 'admin_kutumb/update/$1';
$route['kutumb/delete/(:any)'] = 'admin_kutumb/delete/$1';
$route['kutumb/(:any)'] = 'admin_kutumb/index/$1'; //$1 = page number
$route['child_weight'] = 'admin_kutumb/child_weight';


$route['attendance'] = 'admin_attendance/index';
$route['attendance/showattendence'] = 'admin_attendance/showattendence';
$route['attendance/fillAttendanceDetail'] = 'admin_attendance/fillAttendanceDetail';
$route['attendance/(:any)'] = 'admin_attendance/index/$1'; //$1 = page number


$route['jilla'] = 'admin_jilla/index';
$route['jilla/add'] = 'admin_jilla/add';
$route['jilla/update'] = 'admin_jilla/update';
$route['jilla/update/(:any)'] = 'admin_jilla/update/$1';
$route['jilla/delete/(:any)'] = 'admin_jilla/delete/$1';
$route['jilla/(:any)'] = 'admin_jilla/index/$1'; //$1 = page number

$route['taluka'] = 'admin_taluka/index';
$route['taluka/add'] = 'admin_taluka/add';
$route['taluka/update'] = 'admin_taluka/update';
$route['taluka/update/(:any)'] = 'admin_taluka/update/$1';
$route['taluka/delete/(:any)'] = 'admin_taluka/delete/$1';
$route['taluka/(:any)'] = 'admin_taluka/index/$1'; //$1 = page number

$route['gaam'] = 'admin_gaam/index';
$route['gaam/add'] = 'admin_gaam/add';
$route['gaam/update'] = 'admin_gaam/update';
$route['gaam/remaininggamm'] = 'admin_gaam/remaininggamm';
$route['gaam/update/(:any)'] = 'admin_gaam/update/$1';
$route['gaam/delete/(:any)'] = 'admin_gaam/delete/$1';
$route['gaam/(:any)'] = 'admin_gaam/index/$1'; //$1 = page number

$route['agegroup'] = 'admin_agegroup/index';
$route['agegroup/add'] = 'admin_agegroup/add';
$route['agegroup/update'] = 'admin_agegroup/update';
$route['agegroup/update/(:any)'] = 'admin_agegroup/update/$1';
$route['agegroup/delete/(:any)'] = 'admin_agegroup/delete/$1';
$route['agegroup/(:any)'] = 'admin_agegroup/index/$1'; //$1 = page number


$route['activities'] = 'admin_activities/index';
$route['activities/add'] = 'admin_activities/add';
$route['activities/update'] = 'admin_activities/update';
$route['activities/update/(:any)'] = 'admin_activities/update/$1';
$route['activities/delete/(:any)'] = 'admin_activities/delete/$1';
$route['activities/(:any)'] = 'admin_activities/index/$1'; //$1 = page number


$route['vaccine'] = 'admin_vaccine/index';

$route['holidays'] = 'admin_holidays/index';
$route['holidays/add'] = 'admin_holidays/add';
$route['holidays/update'] = 'admin_holidays/update';
$route['holidays/update/(:any)'] = 'admin_holidays/update/$1';
$route['holidays/delete/(:any)'] = 'admin_holidays/delete/$1';
$route['holidays/(:any)'] = 'admin_holidays/index/$1'; //$1 = page number

$route['item'] = 'admin_item/index';
$route['item/add'] = 'admin_item/add';
$route['item/update'] = 'admin_item/update';
$route['item/update/(:any)'] = 'admin_item/update/$1';
$route['item/delete/(:any)'] = 'admin_item/delete/$1';
$route['item/(:any)'] = 'admin_item/index/$1'; //$1 = page number

$route['item_stock'] = 'admin_item_stock/index';
$route['item_stock/add'] = 'admin_item_stock/add';
$route['item_stock/update'] = 'admin_item_stock/update';
$route['item_stock/update/(:any)'] = 'admin_item_stock/update/$1';
$route['item_stock/delete/(:any)'] = 'admin_item_stock/delete/$1';
$route['item_stock/(:any)'] = 'admin_item_stock/index/$1'; //$1 = page number


/* End of file routes.php */
/* Location: ./application/config/routes.php */
