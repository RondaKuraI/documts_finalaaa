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
$routes->get('/outgoing', 'Home::outgoing');
$routes->get('/maintenance', 'Home::maintenance');
$routes->get('/reports', 'Home::reports');
$routes->get('/user_management', 'Home::user_management');
