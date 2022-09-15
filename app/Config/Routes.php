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
$routes->get('/', 'Home::index');

$routes->get('/login', 'AuthController::indexLogin');
$routes->post('/login', 'AuthController::login');

$routes->get('/register', 'AuthController::indexRegister');
$routes->post('/register', 'AuthController::register');

$routes->get('/profile', 'AuthController::profile');
$routes->get('/login/loginWithGoogle', 'AuthController::loginWithGoogle');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/activateuser', 'AuthController::activateUser');

$routes->get('/forgot-password', 'AuthController::indexforgotPassword');
$routes->get('/forgot-password/submit', 'AuthController::forgotPassword');

$routes->get('/otp-email', 'AuthController::sendOtpEmail');

$routes->get('/send-otp', 'AuthController::indexSendOtp');
$routes->post('/send-otp', 'AuthController::sendOtp');

$routes->group('api/', static function ($routes) {
    $routes->post('register', 'Api\AuthController::register');
    $routes->post('login', 'Api\AuthController::login');
    $routes->get('activateuser', 'Api\AuthController::activateUser');

    $routes->post('forgot-password', 'Api\ForgotPasswordController::forgotPassword');
    $routes->post('send-otp', 'Api\ForgotPasswordController::sendOtp');
    $routes->post('new-password', 'Api\ForgotPasswordController::newPassword');

    $routes->group('faq/', static function ($routes) {
        $routes->get('', 'Api\FaqController::index');
        $routes->post('create', 'Api\FaqController::create');
        $routes->get('detail/(:segment)', 'Api\FaqController::show/$1');
        $routes->put('update/(:segment)', 'Api\FaqController::update/$1');
        $routes->delete('delete/(:segment)', 'Api\FaqController::delete/$1');
    });

    $routes->group('voucher/', static function ($routes) {
        $routes->get('', 'Api\VoucherController::index');
        $routes->get('detail/(:segment)', 'Api\VoucherController::show/$1');
        $routes->post('create', 'Api\VoucherController::create');
        $routes->put('update/(:segment)', 'Api\VoucherController::update/$1');
        $routes->delete('delete/(:segment)', 'Api\VoucherController::delete/$1');
    });

    $routes->get('profile', 'Api\UserController::profile');
});



$routes->get('/sign-up', 'Home::signUp');
$routes->get('/forgot-password', 'Home::forgotPassword');
$routes->get('/send-otp', 'Home::sendOTP');
$routes->get('/new-password', 'Home::newPassword');



$routes->group('api/', static function ($routes) {
    $routes->group('pap/', static function ($routes) {
        $routes->get('', 'Api\PolicyAndPrivacyController::index');
        $routes->get('detail/(:num)', 'Api\PolicyAndPrivacyController::show/$1');
        $routes->post('create', 'Api\PolicyAndPrivacyController::create');
        $routes->put('update/(:num)', 'Api\PolicyAndPrivacyController::update/$1');
        $routes->delete('delete/(:num)', 'Api\PolicyAndPrivacyController::delete/$1');
    });

    $routes->group('course/', static function ($routes) {
        $routes->get('', 'Api\CourseController::index');
        $routes->get('detail/(:num)', 'Api\CourseController::show/$1');
        $routes->post('create', 'Api\CourseController::create');
        $routes->put('update/(:num)', 'Api\CourseController::update/$1');
        $routes->delete('delete/(:num)', 'Api\CourseController::delete/$1');
        $routes->get('latest', 'Api\CourseController::latest');
        $routes->get('latest/(:num)', 'Api\CourseController::latest/$1');
        $routes->get('find/(:segment)', 'Api\CourseController::find/$1');
    });
});


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