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

//static page
$route['404_override'] = 'catalog/general/doView';

$route['default_controller'] = "catalog/cpages";
$route['about'] = "catalog/cpages/about";
$route['carrer'] = "catalog/cpages/carrer";
$route['store'] = "catalog/cpages/store";
$route['page/(:any)'] = 'catalog/cpages/pages/$1';

$route['article'] = "catalog/carticle/pages";
$route['article/(:any)'] = 'catalog/carticle/pages/$1';

$route['cart'] = "catalog/ccart/pages";
$route['cart/(:any)'] = 'catalog/ccart/pages/$1';

$route['checkout'] = "catalog/ccheckout/pages";
$route['checkout/(:any)'] = 'catalog/ccheckout/pages/$1';

$route['login'] = "catalog/cusernonsecure/login";
$route['register'] = "catalog/cusernonsecure/register";
$route['subscribe'] = "catalog/cusernonsecure/subscribe";
$route['update_email/(:any)'] = "catalog/cusernonsecure/change_email/$1";
$route['activated/(:any)'] = "catalog/cusernonsecure/activated/$1";
$route['contact'] = "catalog/cusernonsecure/contact";

$route['admin/product'] = 'admin/cproduct/pages';
$route['admin/product/(:any)'] = 'admin/cproduct/pages/$1';

$route['product'] = "catalog/cproduct/pages";
$route['product/(:any)'] = 'catalog/cproduct/pages/$1';
$route['product/(:any)/(:any)'] = 'catalog/cproduct/pages/$1/$1';

$route['account'] = "catalog/cuser";
$route['profile'] = "catalog/cuser/profile";
$route['confirmation'] = "catalog/cuser/confirmation";
$route['transaction'] = "catalog/cuser/transaction";
$route['confirmation/(:any)'] = 'catalog/cuser/confirmation/$1';

$route['change_email'] = "catalog/cuser/change_email";
$route['change_password'] = "catalog/cuser/change_password";
$route['logout'] = "catalog/cuser/logout";

$route['admin'] = "admin/cadmin";
$route['admin/login'] = "admin/clogin";
$route['admin/logout'] = "admin/cadmin/adminLogout";

$route['admin/email'] = 'admin/cemail/pages';
$route['admin/email/(:any)'] = 'admin/cemail/pages/$1';

$route['admin/checkout'] = 'admin/ccheckout/pages';
$route['admin/checkout/(:any)'] = 'admin/ccheckout/pages/$1';

$route['admin/slider'] = 'admin/cslider/pages';
$route['admin/slider/(:any)'] = 'admin/cslider/pages/$1';
$route['admin/article'] = 'admin/carticle/pages';
$route['admin/article/(:any)'] = 'admin/carticle/pages/$1';


$route['admin/category'] = 'admin/ccategory/pages';
$route['admin/category/(:any)'] = 'admin/ccategory/pages/$1';

$route['admin/pages'] = 'admin/cpages/pages';
$route['admin/pages/(:any)'] = 'admin/cpages/pages/$1';

$route['admin/user'] = 'admin/cuser/pages';
$route['admin/user/(:any)'] = 'admin/cuser/pages/$1';
$route['admin/admin'] = 'admin/cuser/admin';
$route['admin/admin/(:any)'] = 'admin/cuser/admin/$1';
$route['admin/setting'] = "admin/cuser/setting";

$route['(:any)'] = 'catalog/cpages/viewPage/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */