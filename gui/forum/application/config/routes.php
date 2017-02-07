<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'forum';
$route['thread_details/(:any)']= "forum/thread_details/$1";
$route['thread_details_json/(:any)']= "forum/thread_details_json/$1";
$route['forum_json'] ="forum/thread/";
$route['login'] = 'login/index/';
$route['login/(:any)/(:any)'] = 'login/index/$1/$2/';
$route['reply/(:any)'] = 'forum/reply_thread/$1/';
$route['logout'] = 'login/logout/';
$route['new_thread']= "forum/add_thread/";
$route['thread_add']="forum/thread_add";
$route['thread_edit']="forum/thread_edit";
$route['thread_save']="forum/thread_save/";
$route['thread_delete/(:any)']="forum/thread_delete/$1/";
$route['thread_details_add']="forum/thread_details_add/";
$route['thread_detail_edit']= "forum/thread_details_edit/";
$route['thread_details_edit']= "forum/thread_details_save/";
$route['thread_details_delete/(:any)/(:any)']= "forum/thread_details_delete/$1/$2/";
$route['signup'] = 'login/signup/';
$route['users'] = 'users/index/';
$route['users_json'] = "users/users_json/";
$route['user_add'] = "users/user_add/";
$route['user_edit'] = "forum/user_edit/";
$route['update_profile'] = "forum/update_profile/";
$route['user_save'] = "forum/user_save/";
$route['user_delete/(:any)']="users/user_delete/$1";
$route['forgotpass'] = 'login/forgot_password/';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
