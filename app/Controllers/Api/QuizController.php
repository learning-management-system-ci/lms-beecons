<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Quiz;
use App\Models\Users;
use Firebase\JWT\JWT;

class QuizController extends ResourceController
{
    public function __construct()
    {
        $this->quiz = new Quiz();
    }

    public function index($videoId = null)
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);
            $user = new Users;

            // cek role user
            $user = $user->select('role')->where('id', $decoded->uid)->first();

            if ($user['role'] == 'member' || $user['role'] == 'partner') {
                return $this->fail('Tidak dapat di akses selain admin, mentor & author', 400);
            }

            $data = $this->quiz->where('video_id', $videoId)->orderBy('quiz_id', 'DESC')->findAll();

            foreach($data as $key => $data_){
                $data[$key]['question'] = json_decode($data_['question']);
            }

            return $this->respond($data[0]);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data tidak ditemukan');
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
                "video_id" => "required",
                "question" => "required",
            ];

            $messages = [
                "video_id" => [
                    "required" => "{field} tidak boleh kosong"
                ],
                "question" => [
                    "required" => "{field} tidak boleh kosong"
                ],
            ];

            if($this->validate($rules, $messages)) {
                $data = [
                    'video_id' => $this->request->getVar('video_id'),
                    'question' => $this->request->getVar('question'),
                ];
                
                $this->quiz->insert($data);

                $response = [
                    'status'   => 201,
                    'success'    => 201,
                    'messages' => [
                        'success' => 'Data Quiz berhasil dibuat'
                    ]
                ];
            }else{
                $response = [
                    'status'   => 400,
                    'error'    => 400,
                    'messages' => $this->validator->getErrors(),
                ];
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->respondCreated($response);    
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
                "video_id" => "required",
                "question" => "required",
            ];

            $messages = [
                "video_id" => [
                    "required" => "{field} tidak boleh kosong"
                ],
                "question" => [
                    "required" => "{field} tidak boleh kosong"
                ],
            ];

            $data = [
                "video_id" => $input["video_id"],
                "question" => $input["question"],
            ];

            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Quiz berhasil diperbarui'
                ]
            ];

            $cek = $this->quiz->where('quiz_id', $id)->findAll();
            if (!$cek) {
                return $this->failNotFound('Data Quiz tidak ditemukan');
            }

            if (!$this->validate($rules, $messages)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            if ($this->quiz->update($id, $data)) {
                return $this->respond($response);
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
		return $this->failNotFound('Data Quiz tidak ditemukan');
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
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

            $data = $this->quiz->where('quiz_id', $id)->findAll();
            if ($data) {
                $this->quiz->delete($id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Quiz berhasil dihapus'
                    ]
                ];
                return $this->respondDeleted($response);
            } else {
                return $this->failNotFound('Data Quiz tidak ditemukan');
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data Quiz tidak ditemukan');
    }
}
