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

    public function transaction()
    {
        $data = [
            "title" => "Transaction",
        ];
        return view('pages/admin/transaction', $data);
    }

    public function transactionDetail()
    {
        $data = [
            "title" => "Transaction Detail",
        ];
        return view('pages/admin/transaction_detail', $data);
    }

    public function course()
    {
        $data = [
            "title" => "Course",
        ];
        return view('pages/admin/course', $data);
    }

    public function courseDetail()
    {
        $data = [
            "title" => "Course Detail",
        ];
        return view('pages/admin/course_detail', $data);
    }

    public function videoDetail()
    {
        $data = [
            "title" => "Video Detail",
        ];
        return view('pages/admin/video_detail', $data);
    }
}
