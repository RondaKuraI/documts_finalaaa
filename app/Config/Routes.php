<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/dashboard', 'Home::index');
$routes->get('/', 'RegisterController::index');
$routes->match(['get', 'post'], '/store', 'RegisterController::index');
$routes->get('/activate/(:any)', 'RegisterController::activate/$1');
$routes->get('/activate', 'RegisterController::activate');

$routes->get('/login', 'SigninController::index');
$routes->match(['get', 'post'], 'SigninController/loginAuth', 'SigninController::loginAuth');

// Dashboard
$routes->get('/compose', 'Home::compose');
$routes->get('/incoming', 'Home::incoming');
$routes->get('/outgoing', 'FileUploadController::index');
$routes->post('/send', 'FileUploadController::upload');
$routes->get('/doc_view/(:num)', 'FileUploadController::doc_view/$1');
$routes->get('/maintenance', 'Home::maintenance');
// $routes->get('/reports', 'Home::reports');
$routes->get('/user_management', 'Home::user_management');

// User Dashboard
$routes->get('/dashboard', 'UserDBController::dashboard');
// $routes->get('/user_compose', 'UserDBController::compose');
// $routes->get('/user_incoming', 'UserDBController::incoming');
// $routes->get('/outgoing', 'FileUploadController::index');
$routes->get('/user_incoming', 'FetchFileController::index');

$routes->get('user_dashboard/(:num)', 'UserController::show/$1');



$routes->match(['get', 'post'], '/reports', 'GColumnChartController::initChart');

