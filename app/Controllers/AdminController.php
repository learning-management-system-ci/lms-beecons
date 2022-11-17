<?php

namespace App\Controllers;

class AdminController extends BaseController
{
    public function index()
    {
        $data = [
        ];
        return view('pages/admin/index', $data);
    }

    // 
    public function user()
    {
        $data = [
            "title" => "User",
        ];
        return view('pages/admin/user', $data);
    }

    public function userDetail()
    {
        $data = [
            "title" => "User Detail",
        ];
        return view('pages/admin/user_detail', $data);
    }
}
