<?php  defined('BASEPATH') or exit('No direct script access allowed');
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
| 	www.your-site.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://www.codeigniter.com/user_guide/general/routing.html
*/

// public
$route['(journal)/(:num)/(:num)/(:any)']   = 'journal/view/$4';
$route['(journal)/page(/:num)?']           = 'journal/index$2';
$route['(journal)/rss/all.rss']            = 'rss/index';
$route['(journal)/rss/(:any).rss']         = 'rss/category/$2';

// admin
$route['journal/admin/categories(/:any)?'] = 'admin_categories$1';
$route['journal/admin/fields(/:any)?']		= 'admin_fields$1';
