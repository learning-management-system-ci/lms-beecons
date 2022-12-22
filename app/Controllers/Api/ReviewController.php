<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Review;
use App\Models\Users;
use Firebase\JWT\JWT;

class ReviewController extends ResourceController
{

    use ResponseTrait;

    public function __construct()
    {
        $this->review = new Review();
    }

    public function index()
    {
        $data['review'] = $this->review->orderBy('course_id', 'DESC')->findAll();
        return $this->respond($data);
    }

    public function create()
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);
            $user = new Users;

            // // cek role user
            // $data = $user->select('role')->where('id', $decoded->uid)->first();
            // if ($data['role'] != 'member') {
            //     return $this->fail('Tidak dapat di akses selain admin, mentor, partner & author', 400);
            // }

            $rules = [
                "feedback" => "required|max_length[250]",
                // "score" => "numeric|decimal",
                "score" => "decimal",
            ];

            $messages = [
                "feedback" => [
                    "required" => "{field} tidak boleh kosong",
                    "max_length" => "{field} maksimal 255 karakter",
                ],
                "score" => [
                    // "numeric" => "{field} harus berisi nomor",
                    "decimal" => "{field} harus bernilai desimal",
                ],
            ];

            if (!$this->validate($rules, $messages)) {
                $response = [
                    'status' => 500,
                    'error' => true,
                    'message' => $this->validator->getErrors(),
                    'data' => []
                ];
            } else {
                $data['user_id'] = $decoded->uid;
                $data['course_id'] = $this->request->getVar("course_id");
                $data['feedback'] = $this->request->getVar("feedback");
                $data['score'] = $this->request->getVar("score");

                $this->review->save($data);

                $response = [
                    'status' => 200,
                    'error' => false,
                    'message' => 'Review berhasil dibuat',
                    'data' => []
                ];
            }
            return $this->respondCreated($response);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function index_review()
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);
            $user = new Users;

            // cek role user
            $user_id = $user->select('id')->where('id', $decoded->uid)->first();
            $data = $user->select('role')->where('id', $decoded->uid)->first();
            if ($data['role'] != 'member') {
                return $this->fail('Tidak dapat di akses selain member', 400);
            }

            $modelreview = new Review();
            $datareview = $modelreview
                ->where('user_id', $user_id)
                ->orderBy('user_review_id', 'DESC')
                ->findAll();
            if ($datareview) {
                return $this->respond($datareview);
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data Review tidak ditemukan');
    }

    public function delete($id = null)
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);
            $user = new Users;

            // cek role user
            $data = $user->select('role')->where('id', $decoded->uid)->first();
            if ($data['role'] == 'member'  || $data['role'] == 'mentor' || $data['role'] == 'partner') {
                return $this->fail('Tidak dapat di akses selain admin & author', 400);
            }

            $data = $this->review->where('user_review_id', $id)->findAll();
            if ($data) {
                $this->review->delete($id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Review berhasil dihapus'
                    ]
                ];
                return $this->respondDeleted($response);
            } else {
                return $this->failNotFound('Data Review tidak ditemukan');
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data Review tidak ditemukan');
    }

    // public function ratingcourse ($course_id = null){
    //     $cek_course = $this->review->where('course_id', $course_id)->findAll();
        
    //     if ($cek_course != null){
    //         $reviewcourse = $this->review->where('course_id', $course_id)->findAll();

    //         $rating_raw = 0;
    //         $rating_final = 0;

    //         for ($i = 0; $i < count($reviewcourse); $i++) {
    //             $rating_raw += $reviewcourse[$i]['score'];
    //             $rating_final = $rating_raw / count($reviewcourse);

    //             $data['Rating'] = $rating_final;
    //         }
    //     } else {
    //         $data['Rating'] = 0;
    //     }
    //     return $this->respond($data);
    //     // return $this->failNotFound('Course Belum Memiliki Rating');
    // }
}
