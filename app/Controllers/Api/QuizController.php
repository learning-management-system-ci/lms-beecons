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

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $model = new Quiz;
        $data = $model->orderBy('quiz_id', 'DESC')->findAll();
        // $test = json_decode($data[0]['question']);
        // return $this->respond($test->quiz[0]);
        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
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
            if ($data['role'] == 'member' || $data['role'] == 'partner') {
				return $this->fail('Tidak dapat di akses selain admin, mentor & author', 400);
			}

            $rules = [
                'video_id' => 'required|numeric',
                'question' => 'required',
            ];

            $messages = [
                "video_id" => [
                    "required" => "{field} tidak boleh kosong",
                    "numeric" => "{field} hanya berisi angka",
                ],
                "question" => [
                    "required" => "{field} tidak boleh kosong",
                ],
            ];

            if($this->validate($rules, $messages)) {
                $dataquiz = [
                    'video_id' => $this->request->getVar('video_id'),
                    'question' => $this->request->getVar('question'),
                ];
                $this->quiz->insert($dataquiz);

                $response = [
                    'status'   => 201,
                    'success'    => 201,
                    'messages' => [
                        'success' => 'Data quiz berhasil dibuat'
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

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
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
            if ($data['role'] == 'member' || $data['role'] == 'partner') {
				return $this->fail('Tidak dapat di akses selain admin, mentor & author', 400);
			}

            $input = $this->request->getRawInput();

            $rules = [
                'video_id' => 'required|numeric',
                'question' => 'required',
            ];

            $messages = [
                "video_id" => [
                    "required" => "{field} tidak boleh kosong",
                    "numeric" => "{field} hanya berisi angka",
                ],
                "question" => [
                    "required" => "{field} tidak boleh kosong",
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
                    'success' => 'Data Quiz berhasil diperbarui'
                ]
            ];

            $cek = $this->quiz->where('quiz_id', $id)->findAll();

            if(!$cek){
                return $this->failNotFound('Data Quiz tidak ditemukan');
            }

            if (!$this->validate($rules, $messages)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            if ($this->quiz->update($id, $data)){
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
            if ($data['role'] == 'member' || $data['role'] == 'partner') {
				return $this->fail('Tidak dapat di akses selain admin, mentor & author', 400);
			}

            $data = $this->quiz->where('quiz_id', $id)->findAll();
            if($data){
            $this->quiz->delete($id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Data Quiz berhasil dihapus'
                    ]
                ];
            }
            return $this->respondDeleted($response);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data Quiz tidak ditemukan');
    }
}
