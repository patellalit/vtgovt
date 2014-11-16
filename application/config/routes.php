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
$route['kutumb/update/(:any)'] = 'admin_kutumb/update/$1';
$route['kutumb/delete/(:any)'] = 'admin_kutumb/delete/$1';
$route['kutumb/(:any)'] = 'admin_kutumb/index/$1'; //$1 = page number


$route['attendance'] = 'admin_attendance/index';
$route['attendance/showattendence'] = 'admin_attendance/showattendence';
$route['attendance/(:any)'] = 'admin_attendance/index/$1'; //$1 = page number

/* End of file routes.php */
/* Location: ./application/config/routes.php */