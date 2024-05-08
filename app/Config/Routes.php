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
$routes->get('/reports', 'Home::reports');
$routes->get('/user_management', 'Home::user_management');

// User Dashboard
$routes->get('/user_dashboard', 'UserController::dashboard');
$routes->get('/user_compose', 'UserController::compose');
$routes->get('/user_incoming', 'UserController::incoming');
$routes->get('/user_outgoing', 'UserController::outgoing');

// $routes->post('/send', 'EmailController::sendEmail');

$routes->get('chart', 'ChartController::index');
$routes->get('chart/data', 'ChartController::getChartData');


//jQuery Ajax

$routes->post('ajax-student/store', 'AjaxStudentController::store');
$routes->get('ajax-students/getdata', 'AjaxStudentController::fetch');
$routes->post('ajax-student/view_student', 'AjaxStudentController::view');
$routes->post('ajax-student/edit', 'AjaxStudentController::edit');
$routes->post('ajax-student/update', 'AjaxStudentController::update');
$routes->post('ajax-student/delete', 'AjaxStudentController::delete');

