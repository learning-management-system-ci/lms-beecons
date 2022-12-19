<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserNotification;
use Firebase\JWT\JWT;

class UserNotificationController extends ResourceController
{
    public function __construct()
    {
        $this->usernotification = new UserNotification();
    }
    
    public function index()
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);

            $data = $this->usernotification->where('user_id', $decoded->uid)->orderBy('user_notification_id', 'ASC')->findAll();

            return $this->respond($data);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data tidak ditemukan');
    }

    public function detail($notification_id = null)
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);

            $data = $this->usernotification->where('user_id', $decoded->uid)->where('user_notification_id', $notification_id)->first();

            if ($data == null){
                return $this->failNotFound('Data dengan user_notification_id ' . $notification_id . ' tidak ditemukan pada user_id ' . $decoded->uid);
            }
            return $this->respond($data);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data tidak ditemukan');
    }
}
