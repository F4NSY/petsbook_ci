<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Pages';
$route['friends/(:any)'] = 'Pages/friends/$1';
$route['friends'] = 'Pages/friends';
$route['pages'] = 'Pages';
$route['api'] = 'Api';
$route['(:any)'] = 'Pages/index/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
