<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Resume;
use App\Models\Users;
use Firebase\JWT\JWT;

class ResumeController extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->resume = new Resume();
    }

    public function index(){
        $dataresume = $this->resume->findAll();
        return $this->respond($dataresume);
    }
    
    public function show($id = null){
        $data = $this->resume->where('resume_id', $id)->first();
        
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Data Resume tidak ditemukan');
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

            $rules = [
                'video_id' => 'required',
                'resume' => 'required|max_length[3000]'
            ];

            $messages = [
                "video_id" => [
                    "required" => "{field} tidak boleh kosong",
                ],
                "resume" => [
                    "required" => "{field} tidak boleh kosong",
                    "max_length" => "{field} maksimal 3000 karakter",
                ],
            ];

            if($this->validate($rules, $messages)) {
                $dataresume = [
                    'video_id' => $this->request->getVar('video_id'),
                    'user_id' => $decoded->uid,
                    'resume' => $this->request->getVar('resume'),
                ];
                $this->resume->insert($dataresume);

                $response = [
                    'status'   => 201,
                    'success'    => 201,
                    'messages' => [
                        'success' => 'Resume berhasil dibuat'
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

    public function update($id = null){
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);

            $input = $this->request->getRawInput();

            $rules = [
                'video_id' => 'required',
                'resume' => 'required|max_length[3000]'
            ];

            $messages = [
                "video_id" => [
                    "required" => "{field} tidak boleh kosong",
                ],
                "resume" => [
                    "required" => "{field} tidak boleh kosong",
                    "max_length" => "{field} maksimal 3000 karakter",
                ],
            ];

            $data = [
                "video_id" => $input["video_id"],
                "user_id" => $decoded->uid,
                "resume" => $input["resume"],
            ];

            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Resume berhasil diperbarui'
                ]
            ];

            $cek = $this->resume->where('resume_id', $id)->findAll();

            if(!$cek){
                return $this->failNotFound('Data Resume tidak ditemukan');
            }

            if (!$this->validate($rules, $messages)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            if ($this->resume->update($id, $data)){
                return $this->respond($response);
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
		return $this->failNotFound('Data Resume tidak ditemukan');
	}

    public function delete($id = null){
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);

            $data = $this->resume->where('resume_id', $id)->findAll();
            if($data){
            $this->resume->delete($id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'resume berhasil dihapus'
                    ]
                ];
            }
            return $this->respondDeleted($response);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data resume tidak ditemukan');
    }
}