<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Halaman awal: arahkan ke dashboard (AuthFilter akan melempar ke login jika belum masuk).
$routes->addRedirect('/', 'dashboard');

// Autentikasi
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::attempt');
$routes->post('logout', 'Auth::logout');

// Halaman yang wajib login
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);