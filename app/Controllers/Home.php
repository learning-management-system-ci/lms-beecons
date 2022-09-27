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
        return view('pages/navigation/about_us');
    }
    public function termsAndConditions()
    {
        return view('pages/navigation/terms_and_condition');
    }
    public function bundlingCart()
    {
        return view('pages/course/bundling');
    }
    public function courseDetail()
    {
        $data = [
            "title" => "Courses",
        ];
        return view('pages/course/course-detail', $data);
    }
    public function cart()
    {
        return view('pages/course/cart');
    }

    public function webinar()
    {
        return view('pages/navigation/webinar');
    }
    public function training()
    {
        return view('pages/navigation/training');
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
}
