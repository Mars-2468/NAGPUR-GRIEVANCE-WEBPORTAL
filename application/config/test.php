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
$route['default_controller'] = 'HomeController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['home-page/:num'] = 'HomeController';

$route['Basic-Information']='CustomePageController/getPageContent/';
$route['About-Municipality']='CustomePageController/getPageContent/';
$route['About-Adilabad']='CustomePageController/getPageContent/';
$route['Citizen-Services']='CustomePageController/getPageContent/';
$route['Property-Tax']='CustomePageController/getPageContent/';
$route['Public-Contacts']='CustomePageController/getPageContent/';
$route['Officers-service-Del']='CustomePageController/getPageContent/';
$route['Dashboard']='CustomePageController/getPageContent/';
$route['Mutation-Dashboard']='CustomePageController/getPageContent/';
$route['Online-Applications']='CustomePageController/getPageContent/';
$route['New-Water-Tap-Applic']='CustomePageController/getPageContent/';
$route['Contacts']='CustomePageController/getPageContent/';
$route['Commissioner-Contact']='CustomePageController/getPageContent/';
$route['Council']='CustomePageController/getPageContent/';
$route['Orgnizational-chart']='CustomePageController/getPageContent/';
$route['chakri-testing']='CustomePageController/getPageContent/';
$route['Adilabad-Master-plan']='CustomePageController/getPageContent/';
$route['public-servicesameni']='CustomePageController/getPageContent/';
$route['public-servicesameni']='CustomePageController/getPageContent/';
$route['fdf']='CustomePageController/getPageContent/';
$route['Basic-Information']='CustomePageController/getPageContent/';
$route['About-Adilabad']='CustomePageController/getPageContent/';
$route['Basic-Information']='CustomePageController/getPageContent/';
$route['Basic-Information']='CustomePageController/getPageContent/';
$route['Counci-list']='CustomePageController/getPageContent/';
$route['']='CustomePageController/getPageContent/';
$route['']='CustomePageController/getPageContent/';
$route['']='CustomePageController/getPageContent/';
$route['Adilabad-basic-infor']='CustomePageController/getPageContent/';
$route['']='CustomePageController/getPageContent/';
$route['About-Municipality']='CustomePageController/getPageContent/';
$route['Citizen-charter']='CustomePageController/getPageContent/';
$route['Property-tax']='CustomePageController/getPageContent/';
$route['Water-tap-connection']='CustomePageController/getPageContent/';
$route['Public-contacts']='CustomePageController/getPageContent/';
$route['officers-sanctioning']='CustomePageController/getPageContent/';
$route['Dashboard']='CustomePageController/getPageContent/';
$route['Mutation-dashboard']='CustomePageController/getPageContent/';
$route['మున్సి�']='CustomePageController/getPageContent/';
$route['5878a7ab84fb43402106']='CustomePageController/getPageContent/';
$route['5837e05c0213dc1617e4']='CustomePageController/getPageContent/';
$route['15f99f2165aa8c86c9df']='CustomePageController/getPageContent/';
$route['New-tender-notificat']='CustomePageController/getPageContent/';
$route['Online-Applications']='CustomePageController/getPageContent/';
$route['Telangana-budget-201']='CustomePageController/getPageContent/';
$route['Telangana-budget-201']='CustomePageController/getPageContent/';
$route['Online-Applications']='CustomePageController/getPageContent/';
$route['ec0f40c389aeef789ce0']='CustomePageController/getPageContent/';
$route['f410588e48dc83f2822a']='CustomePageController/getPageContent/';
$route['Online-Applications']='CustomePageController/getPageContent/';
$route['fecbfa88f364df34c327']='CustomePageController/getPageContent/';
$route['Online-Applications']='CustomePageController/getPageContent/';
$route['94739e5a5164b4d2396e']='CustomePageController/getPageContent/';
$route['aa495e18c7e3a21a4e48']='CustomePageController/getPageContent/';
$route['Telangana-budget-201']='CustomePageController/getPageContent/';
$route['Swachh-municipality']='CustomePageController/getPageContent/';
$route['']='CustomePageController/getPageContent/';
$route['Council-list-of-adilabad']='CustomePageController/getPageContent/';