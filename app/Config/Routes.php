<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/about', 'About::index');
$routes->get('/services', 'Services::index');
$routes->match(['get', 'post'], '/contact', 'Contact::index');
$routes->get('/register', 'Register::index');
$routes->post('/register', 'Register::create');
$routes->get('/login', 'Login::index');
$routes->post('/login', 'Login::authenticate', ['filter' => 'csrf']);
$routes->post('/logout', 'Login::logout', ['filter' => 'csrf']);
$routes->group('', ['filter' => 'dashboardAuth'], static function ($routes) {
    $routes->get('/dashboard', 'Dashboard::index');
    $routes->get('/account/new', 'Dashboard::newAccount');
    $routes->post('/account', 'Dashboard::createAccount', ['filter' => 'csrf']);
    $routes->get('/account/(:num)', 'Dashboard::viewAccount/$1');
    $routes->get('/account/(:num)/edit', 'Dashboard::editAccount/$1');
    $routes->post('/account/(:num)/edit', 'Dashboard::updateAccount/$1', ['filter' => 'csrf']);
    $routes->post('/account/(:num)/delete', 'Dashboard::deleteAccount/$1', ['filter' => 'csrf']);
});
