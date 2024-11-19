<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//Register and Login
$routes->get('/', 'RegisterController::index');
$routes->match(['get', 'post'], '/store', 'RegisterController::index');
$routes->get('/activate/(:any)', 'RegisterController::activate/$1');
$routes->get('/activate', 'RegisterController::activate');

$routes->get('/login', 'SigninController::index');
$routes->match(['get', 'post'], 'SigninController/loginAuth', 'SigninController::loginAuth');

$routes->get('logout', 'SigninController::logout');

// Dashboard

$routes->group('', ['filter' => 'auth'], function($routes){
    $routes->get('/dashboard', 'FileUploadController::dashboard');
    $routes->get('/compose', 'FileUploadController::compose');
    // $routes->get('/incoming', 'Home::incoming');
    $routes->get('/outgoing', 'FileUploadController::index');
    $routes->post('/send', 'FileUploadController::upload');
    $routes->get('/doc_view/(:num)', 'FileUploadController::doc_view/$1');
    $routes->get('view/file/(:num)', 'FileUploadController::viewFile/$1');
    $routes->get('serve/file/(:num)', 'FileUploadController::serveFile/$1');
    $routes->get('/incoming_doc_view/(:num)', 'FileUploadController::incoming_doc_view/$1');
    $routes->get('/maintenance', 'ChartController::index');
    // $routes->get('/reports', 'Home::reports');
    // $routes->get('/user_management', 'Home::user_management');
    $routes->get('search', 'FileUploadController::search');
    $routes->get('incoming', 'FileUploadController::incoming');
    $routes->get('all_documents', 'FileUploadController::allDocuments');
    $routes->get('document-chart', 'ChartController::index');
    $routes->get('/messages', 'MessageController::messages');
    
    $routes->post('reply/(:num)', 'FileUploadController::reply/$1');
    $routes->get('conversation/(:num)', 'FileUploadController::showConversations/$1');

});

$routes->post('generate-qr', 'FileUploadController::generateQR');
$routes->post('check-doc-code', 'FileUploadController::checkDocCodeUniqueness');

// New routes for incoming documents
$routes->get('dashboard/message/view/(:num)', 'FileUploadController::viewMessage/$1');

$routes->get('/user_management', 'UserController::user_management');

$routes->post('update-status', 'UpdateDocStatusController::updateStatus');


























// User Dashboard
$routes->get('/dashboard', 'UserDBController::dashboard');
// $routes->get('/user_compose', 'UserDBController::compose');
// $routes->get('/user_incoming', 'UserDBController::incoming');
// $routes->get('/outgoing', 'FileUploadController::index');
$routes->get('/user_incoming', 'FetchFileController::index');

$routes->get('user_dashboard/(:num)', 'UserController::show/$1');



$routes->match(['get', 'post'], '/reports', 'GColumnChartController::initChart');

