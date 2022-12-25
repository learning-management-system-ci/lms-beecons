<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\VideoCategory;
use App\Models\Users;
use Firebase\JWT\JWT;

class VideoCategoryController extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->videocategory = new VideoCategory();
    }

    public function index()
    {
        $data = $this->videocategory->orderBy('video_category_id', 'DESC')->findAll();

        if (count($data) > 0) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Tidak video category ada data');
        }
    }

    public function show($id = null)
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);
            $data = $this->videocategory->where('video_category_id', $id)->first();
            if ($data) {
                return $this->respond($data);
            } else {
                return $this->failNotFound('Data video category tidak ditemukan');
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
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

            // cek role user
            $data = $user->select('role')->where('id', $decoded->uid)->first();
            if ($data['role'] == 'member') {
                return $this->fail('Tidak dapat di akses oleh member', 400);
            }

            $rules = [
                "course_id" => "required",
            ];

            $messages = [
                "course_id" => [
                    "required" => "{field} tidak boleh kosong"
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
                $data['course_id'] = $this->request->getVar("course_id");
                $data['title'] = $this->request->getVar("title");

                $this->videocategory->save($data);

                $response = [
                    'status' => 200,
                    'error' => false,
                    'message' => 'Data video category berhasil dibuat',
                    'data' => []
                ];
            }
            return $this->respondCreated($response);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function update($id = null)
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
            if ($data['role'] == 'member') {
                return $this->fail('Tidak dapat di akses oleh member', 400);
            }

            $input = $this->request->getRawInput();
            $rules = [
                "course_id" => "required",
            ];
            $messages = [
                "course_id" => [
                    "required" => "{field} tidak boleh kosong"
                ],
            ];

            $data = [
                "course_id" => $input["course_id"],
                "title" => $input["title"],
            ];

            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'video category berhasil diperbarui'
                ]
            ];

            $cek = $this->videocategory->where('video_category_id', $id)->findAll();
            if (!$cek) {
                return $this->failNotFound('Data video category tidak ditemukan');
            }

            if (!$this->validate($rules, $messages)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            if ($this->videocategory->update($id, $data)) {
                return $this->respond($response);
            }
            return $this->failNotFound('Data video category tidak ditemukan');
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
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
            if ($data['role'] == 'member') {
                return $this->fail('Tidak dapat di akses oleh member', 400);
            }

            $data = $this->videocategory->where('video_category_id', $id)->findAll();
            if ($data) {
                $this->videocategory->delete($id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Data video category berhasil dihapus'
                    ]
                ];
                return $this->respondDeleted($response);
            } else {
                return $this->failNotFound('Data video category tidak ditemukan');
            }
	    } catch (\Throwable $th) {
            // return $this->fail($th->getMessage());
            exit($th->getMessage());
        }
    }
}
