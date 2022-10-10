<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            "title" => "Learning Platform",
        ];
        return view('pages/home/home', $data);
    }
    public function login()
    {
        return view('pages/authentication/login');
    }
    public function signUp()
    {
        return view('pages/authentication/sign_up');
    }
    public function forgotPassword()
    {
        return view('pages/authentication/forgot_password');
    }
    public function sendOTP()
    {
        return view('pages/authentication/otp_code');
    }
    public function newPassword()
    {
        return view('pages/authentication/new_password');
    }


    public function faq()
    {
        return view('pages/navigation/faq');
    }
    public function aboutUs()
    {
        $data = [
            "title" => "About Us",
        ];
        return view('pages/navigation/about_us', $data);
    }
    public function termsAndConditions()
    {
        $data = [
            "title" => "Terms and Conditions",
        ];
        return view('pages/navigation/terms_and_condition', $data);
    }
    public function bundlingCart()
    {
        $data = [
            "title" => "Bundling",
        ];
        return view('pages/course/bundling', $data);
    }
    public function courseDetail()
    {
        $data = [
            "title" => "Detail Course",
        ];
        return view('pages/course/course-detail', $data);
    }
    public function cart()
    {
        $data = [
            "title" => "Cart Anda",
        ];
        return view('pages/course/cart', $data);
    }

    public function webinar()
    {
        $data = [
            "title" => "Webinar",
        ];
        return view('pages/navigation/webinar', $data);
    }
    public function training()
    {
        $data = [
            "title" => "Training",
        ];
        return view('pages/navigation/training', $data);
    }
    public function courses()
    {
        $data = [
            "title" => "Courses",
        ];
        return view('pages/navigation/courses', $data);
    }
    public function article()
    {
        $data = [
            "title" => "Artikel",
        ];
        return view('pages/navigation/article', $data);
    }
    public function checkout()
    {
        $data = [
            "title" => "Checkout",
        ];
        return view('pages/course/checkout', $data);
    }
}
