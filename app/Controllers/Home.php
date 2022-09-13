<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('pages/home/home');
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
    public function bundleCart()
    {
        return view('pages/shop_cart/bundle');
    }
}
