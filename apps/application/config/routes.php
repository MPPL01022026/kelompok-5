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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'auth/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth Routes
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';

// Dashboard
$route['dashboard'] = 'dashboard/index';

// Bahan
$route['bahan'] = 'bahan/index';
$route['bahan/tambah'] = 'bahan/tambah';
$route['bahan/edit/(:num)'] = 'bahan/edit/$1';
$route['bahan/hapus/(:num)'] = 'bahan/hapus/$1';
$route['bahan/get/(:num)'] = 'bahan/get/$1';

// Stok Masuk
$route['stok-masuk'] = 'stok_masuk/index';
$route['stok-masuk/tambah'] = 'stok_masuk/tambah';
$route['stok-masuk/hapus/(:num)'] = 'stok_masuk/hapus/$1';
$route['stok_masuk'] = 'stok_masuk/index';
$route['stok_masuk/tambah'] = 'stok_masuk/tambah';
$route['stok_masuk/hapus/(:num)'] = 'stok_masuk/hapus/$1';

// Stok Keluar
$route['stok-keluar'] = 'stok_keluar/index';
$route['stok-keluar/tambah'] = 'stok_keluar/tambah';
$route['stok-keluar/hapus/(:num)'] = 'stok_keluar/hapus/$1';
$route['stok_keluar'] = 'stok_keluar/index';
$route['stok_keluar/tambah'] = 'stok_keluar/tambah';
$route['stok_keluar/hapus/(:num)'] = 'stok_keluar/hapus/$1';

// Status Stok
$route['status-stok'] = 'status_stok/index';

// Riwayat
$route['riwayat'] = 'riwayat/index';

// Laporan
$route['laporan'] = 'laporan/index';
$route['laporan/cetak'] = 'laporan/cetak';

// API for Dashboard
$route['api/dashboard-stats'] = 'dashboard/get_stats';

