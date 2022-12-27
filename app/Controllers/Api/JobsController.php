<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Jobs;
use App\Models\Users;
use Firebase\JWT\JWT;

class JobsController extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->jobs = new Jobs();
        $this->users = new Users();
    }

    public function index()
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);

            $data = $this->jobs->select('job_id, job_name')->findAll();
            if ($data) {
                return $this->respond($data);
            } else {
                return $this->failNotFound('Data pekerjaan tidak ditemukan');
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
            if ($data['role'] != 'admin') {
				return $this->fail('Tidak dapat di akses selain admin', 400);
			}

            $rules = [
                'job_name' => 'required',
            ];

            $messages = [
                "job_name" => [
                    "required" => "{field} tidak boleh kosong",
                ],
            ];

            if($this->validate($rules, $messages)) {
                $datajobs = [
                    'job_name' => $this->request->getVar('job_name'),
                ];
                $this->jobs->insert($datajobs);

                $response = [
                    'status'   => 201,
                    'success'    => 201,
                    'messages' => [
                        'success' => 'Data pekerjaan berhasil dibuat'
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
            $user = new Users;

            // cek role user
            $data = $user->select('role')->where('id', $decoded->uid)->first();
            if ($data['role'] != 'admin') {
				return $this->fail('Tidak dapat di akses selain admin', 400);
			}

            $input = $this->request->getRawInput();

            $rules = [
                'job_name' => 'required',
            ];

            $messages = [
                "job_name" => [
                    "required" => "{field} tidak boleh kosong",
                ],
            ];

            $data = [
                "job_name" => $input["job_name"],
            ];

            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Data pekerjaan berhasil diperbarui'
                ]
            ];

            $cek = $this->jobs->where('job_id', $id)->findAll();

            if(!$cek){
                return $this->failNotFound('Data pekerjaan tidak ditemukan');
            }

            if (!$this->validate($rules, $messages)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            if ($this->jobs->update($id, $data)){
                return $this->respond($response);
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
		return $this->failNotFound('Data pekerjaan tidak ditemukan');
	}

    public function delete($id = null){
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);
            $user = new Users;

            // cek role user
            $data = $user->select('role')->where('id', $decoded->uid)->first();
            if ($data['role'] != 'admin') {
				return $this->fail('Tidak dapat di akses selain admin', 400);
			}

            $data = $this->jobs->where('job_id', $id)->findAll();
            if($data){
                $this->jobs->delete($id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Data pekerjaan berhasil dihapus'
                    ]
                ];
            }
            return $this->respondDeleted($response);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data pekerjaan tidak ditemukan');
    }
}
