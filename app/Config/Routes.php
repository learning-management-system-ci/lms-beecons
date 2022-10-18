<?php

namespace Config;

use Doctrine\Common\Annotations\PhpParser;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;

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
$routes->get('/login/loginWithGoogle', 'Api\AuthController::loginWithGoogle');
$routes->post('/login/loginOneTapGoogle', 'Api\AuthController::loginOneTapGoogle');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/activateuser', 'AuthController::activateUser');

$routes->get('/forgot-password', 'AuthController::indexforgotPassword');
$routes->get('/forgot-password/submit', 'AuthController::forgotPassword');

$routes->get('/otp-email', 'AuthController::sendOtpEmail');

$routes->get('/send-otp', 'AuthController::indexSendOtp');
$routes->post('/send-otp', 'AuthController::sendOtp');

$routes->get('/new-password', 'AuthController::indexNewPassword');
$routes->post('/new-password', 'AuthController::newPassword');
$routes->get('/referral-code', 'AuthController::referralCode');

$routes->get('/faq', 'Client\FaqController::index');
$routes->get('/about-us', 'Home::aboutUs');
$routes->get('/terms-and-conditions', 'Home::termsAndConditions');
$routes->get('/courses/bundling', 'Home::bundlingCart');
$routes->get('/course-detail', 'Home::courseDetail');
$routes->get('/course/:num', 'Home::courseDetailNew');
$routes->get('/cart', 'Home::cart');
$routes->get('/checkout', 'Home::checkout');
$routes->get('/webinar', 'Home::webinar');
$routes->get('/training', 'Home::training');
$routes->get('/courses', 'Home::courses');
$routes->get('/article', 'Home::article');
$routes->get('/email', 'Home::email');

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

    $routes->group('review/', static function ($routes) {
        $routes->get('', 'Api\ReviewController::index');
        $routes->get('detail', 'Api\ReviewController::index_review');
        $routes->post('create', 'Api\ReviewController::create');
    });

    $routes->group('testimoni/', static function ($routes) {
        $routes->get('', 'Api\TestimoniController::index');
        $routes->get('detail/(:segment)', 'Api\TestimoniController::show/$1');
        $routes->post('create', 'Api\TestimoniController::create');
        $routes->put('update/(:segment)', 'Api\TestimoniController::update/$1');
        $routes->delete('delete/(:segment)', 'Api\TestimoniController::delete/$1');
    });

    $routes->group('pap/', static function ($routes) {
        $routes->get('', 'Api\PolicyAndPrivacyController::index');
        $routes->get('detail/(:num)', 'Api\PolicyAndPrivacyController::show/$1');
        $routes->post('create', 'Api\PolicyAndPrivacyController::create');
        $routes->put('update/(:num)', 'Api\PolicyAndPrivacyController::update/$1');
        $routes->delete('delete/(:num)', 'Api\PolicyAndPrivacyController::delete/$1');
    });

    $routes->group('users/', static function ($routes) {
        $routes->get('', 'Api\UserController::profile');
        $routes->get('jobs', 'Api\UserController::jobs');
        $routes->get('mentor', 'Api\UserController::getMentor');
        $routes->put('update/(:num)', 'Api\UserController::update/$1');
    });

    $routes->group('course/', static function ($routes) {
        $routes->get('', 'Api\CourseController::index');
        $routes->get('detail/(:num)', 'Api\CourseController::show/$1');
        $routes->post('create', 'Api\CourseController::create');
        $routes->put('update/(:num)f', 'Api\CourseController::update/$1');
        $routes->delete('delete/(:num)', 'Api\CourseController::delete/$1');
        $routes->get('latest', 'Api\CourseController::latest');
        $routes->get('latest/(:num)', 'Api\CourseController::latest/$1');
        $routes->get('find/(:segment)', 'Api\CourseController::find/$1');
        $routes->get('filter/(:segment)', 'Api\CourseController::filter/$1');

        $routes->group('video/', static function ($routes) {
            $routes->get('(:num)', 'Api\VideoController::index/$1');
            $routes->post('create', 'Api\VideoController::create');
            $routes->post('update/(:segment)', 'Api\VideoController::update/$1');
            $routes->delete('delete/(:segment)', 'Api\VideoController::delete/$1');
        });
    });

    $routes->group('user-video/', static function ($routes) {
        $routes->get('', 'Api\UserVideoController::index');
        $routes->get('detail/(:segment)', 'Api\UserVideoController::show/$1');
        $routes->get('detail/(:segment)/(:segment)', 'Api\UserVideoController::showuser/$1/$2');
        $routes->post('create', 'Api\UserVideoController::create');
        $routes->put('update/(:segment)', 'Api\UserVideoController::update/$1');
        $routes->delete('delete/(:segment)', 'Api\UserVideoController::delete/$1');
    });

    $routes->group('bundling/', static function ($routes) {
        $routes->get('', 'Api\BundlingController::index');
        $routes->get('detail/(:segment)', 'Api\BundlingController::show/$1');
        $routes->post('create', 'Api\BundlingController::create');
        $routes->put('update/(:segment)', 'Api\BundlingController::update/$1');
        $routes->delete('delete/(:segment)', 'Api\BundlingController::delete/$1');
    });

    $routes->group('course-bundling/', static function ($routes) {
        $routes->get('', 'Api\CourseBundlingController::index');
        $routes->get('detail/(:segment)', 'Api\CourseBundlingController::show/$1');
        $routes->post('create', 'Api\CourseBundlingController::create');
        $routes->put('update/(:segment)', 'Api\CourseBundlingController::update/$1');
        $routes->delete('delete/(:segment)', 'Api\CourseBundlingController::delete/$1');
    });

    $routes->group('category/', static function ($routes) {
        $routes->get('', 'Api\CategoryController::index');
        $routes->get('detail/(:num)', 'Api\CategoryController::show/$1');
        $routes->post('create', 'Api\CategoryController::create');
        $routes->put('update/(:num)', 'Api\CategoryController::update/$1');
        $routes->delete('delete/(:num)', 'Api\CategoryController::delete/$1');
    });

    $routes->group('category-bundling/', static function ($routes) {
        $routes->get('', 'Api\CategoryBundlingController::index');
        $routes->get('detail/(:num)', 'Api\CategoryBundlingController::show/$1');
        $routes->post('create', 'Api\CategoryBundlingController::create');
        $routes->put('update/(:num)', 'Api\CategoryBundlingController::update/$1');
        $routes->delete('delete/(:num)', 'Api\CategoryBundlingController::delete/$1');
    });

    $routes->group('video-category/', static function ($routes) {
        $routes->get('', 'Api\VideoCategoryController::index');
        $routes->get('detail/(:num)', 'Api\VideoCategoryController::show/$1');
        $routes->post('create', 'Api\VideoCategoryController::create');
        $routes->put('update/(:num)', 'Api\VideoCategoryController::update/$1');
        $routes->delete('delete/(:num)', 'Api\VideoCategoryController::delete/$1');
    });

    $routes->group('tag/', static function ($routes) {
        $routes->get('', 'Api\TagController::index');
        $routes->get('detail/(:num)', 'Api\TagController::show/$1');
        $routes->post('create', 'Api\TagController::create');
        $routes->put('update/(:num)', 'Api\TagController::update/$1');
        $routes->delete('delete/(:num)', 'Api\TagController::delete/$1');
    });

    $routes->group('course_tag/', static function ($routes) {
        $routes->get('', 'Api\CourseTagController::index');
        $routes->get('filter/(:segment)/(:num)', 'Api\CourseTagController::filter/$1/$2');
    });

    $routes->group('course_category/', static function ($routes) {
        $routes->get('', 'Api\CourseCategoryController::index');
        $routes->get('filter/(:segment)/(:num)', 'Api\CourseCategoryController::filter/$1/$2');
    });


    $routes->group('notification/', static function ($routes) {
        // domain/api/notification/{user_id yang sedang login}
        // akan memberikan output semua notifikasi user tersebut dan juga public notifikasi
        $routes->get('', 'Api\NotificationController::index');
        $routes->post('create', 'Api\NotificationController::create');
        $routes->put('update/(:num)', 'Api\NotificationController::update/$1');
        $routes->delete('delete/(:num)', 'Api\NotificationController::delete/$1');
    });

    $routes->group('type/', static function ($routes) {
        $routes->get('', 'Api\TypeController::index');
        $routes->get('detail/(:num)', 'Api\TypeController::show/$1');
        $routes->post('create', 'Api\TypeController::create');
        $routes->put('update/(:num)', 'Api\TypeController::update/$1');
        $routes->delete('delete/(:num)', 'Api\TypeController::delete/$1');
    });

    $routes->group('course_type/', static function ($routes) {
        $routes->get('', 'Api\CourseTypeController::index');
        $routes->get('filter/(:segment)/(:num)', 'Api\CourseTypeController::filter/$1/$2');
    });

    $routes->group('type_tag/', static function ($routes) {
        $routes->get('', 'Api\TypeTagController::index');
        $routes->get('filter/(:segment)/(:num)', 'Api\TypeTagController::filter/$1/$2');
    });

    $routes->group('cart/', static function ($routes) {
        $routes->get('', 'Api\CartController::index');
        $routes->post('create/(:segment)/(:num)', 'Api\CartController::create/$1/$2');
        $routes->delete('delete/(:num)', 'Api\CartController::delete/$1');
    });

    $routes->group('mentor/', static function ($routes) {
        $routes->get('', 'Api\MentorController::index');
    });

    $routes->group('order/', static function ($routes) {
        $routes->get('', 'Api\OrderController::index');
        $routes->get('generatesnap', 'Api\OrderController::generateSnap');
        $routes->post('notif-handler', 'Api\OrderController::notifHandler');
    });

    $routes->group('quiz/', static function ($routes) {
        $routes->get('', 'Api\QuizController::index');
    });

    $routes->get('user-course', 'Api\UserCourseController::index');
    $routes->get('profile', 'Api\UserController::profile');
});

$routes->get('/sign-up', 'Home::signUp');
$routes->get('/forgot-password', 'Home::forgotPassword');
$routes->get('/send-otp', 'Home::sendOTP');
$routes->get('/new-password', 'Home::newPassword');


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
