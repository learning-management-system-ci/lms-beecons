<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Users;
use App\Models\UserCourse;
use App\Models\Course;
use App\Models\Jobs;
use Firebase\JWT\JWT;

class UserCourseController extends ResourceController
{
    use ResponseTrait;

    public function index() {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);
            $userCourse = new UserCourse;

            $userId = $decoded->uid;
            $data = $userCourse->getData($userId)->getResultArray();
            $dataUsers = [];
            foreach($data as $value) {
                $dataUsers[] = [
                    'course_id' => $value['course_id'],
                    'title' => $value['title'],
                    'description' => $value['description'],
                    'price' => $value['price'],
                    'is_access' => $value['is_access']
                ];
            }

            return $this->respond($dataUsers);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data user tidak ditemukan');   
    }
}
