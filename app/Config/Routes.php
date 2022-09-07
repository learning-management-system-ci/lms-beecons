<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'AuthController::indexLogin');
$routes->get('/', 'Home::index');

$routes->get('/login', 'AuthController::indexLogin');
$routes->post('/login', 'AuthController::login');

$routes->get('/register', 'AuthController::indexRegister');
$routes->post('/register', 'AuthController::register');

$routes->get('/profile', 'AuthController::profile');
$routes->get('/login/profile', 'AuthController::profile');
$routes->get('/login/loginWithGoogle', 'AuthController::loginWithGoogle');
$routes->get('/login/logout', 'AuthController::logout');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/activateuser', 'AuthController::activateUser');

$routes->get('/forgot-password', 'AuthController::indexforgotPassword');
$routes->get('/forgot-password/submit', 'AuthController::forgotPassword');

$routes->get('/otp-email', 'AuthController::sendOtpEmail');

$routes->get('/send-otp', 'AuthController::indexSendOtp');
$routes->post('/send-otp', 'AuthController::sendOtp');

$routes->get('/new-password', 'AuthController::indexNewPassword');
$routes->post('/new-password', 'AuthController::newPassword');



// $routes->get('/', 'Home::index');
// $routes->get('/login', 'Home::login');
// $routes->get('/sign-up', 'Home::signUp');
// $routes->get('/forgot-password', 'Home::forgotPassword');
// $routes->get('/send-otp', 'Home::sendOTP');
// $routes->get('/new-password', 'Home::newPassword');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
