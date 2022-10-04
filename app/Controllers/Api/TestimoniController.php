<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Testimoni;
use App\Models\Users;
use Firebase\JWT\JWT;

class TestimoniController extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->testimoni = new Testimoni();
    }

    public function index(){
        $data = $this->testimoni->getTestimoni();
        $datatestimoni = [];
        foreach($data as $value) {
            $datatestimoni[] = [
                'testimoni_id' => $value['testimoni_id'],
                'user' => $this->testimoni->getDataUser($data_user_id = $value['user_id']),
                'testimoni' => $value['testimoni'],
                'created_at' => $value['created_at'],
                'updated_at' => $value['updated_at'],
            ];
        }
        return $this->respond($datatestimoni);
    }
    
    public function show($id = null){
        $data = $this->testimoni->getShow($id);
        $datatestimoni = [];
        foreach($data as $value) {
            $datatestimoni[] = [
                'testimoni_id' => $value['testimoni_id'],
                'user' => $this->testimoni->getDataUser($data_user_id = $value['user_id']),
                'testimoni' => $value['testimoni'],
                'created_at' => $value['created_at'],
                'updated_at' => $value['updated_at'],
            ];
        }
        if($datatestimoni){
            return $this->respond($datatestimoni);
        }else{
            return $this->failNotFound('Data Testimoni tidak ditemukan');
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
            if($data['role'] != 'admin'){
                return $this->fail('Tidak dapat di akses selain admin', 400);
            }

            $rules = [
                'user_id' => 'required',
                'testimoni' => 'required|max_length[255]'
            ];

            $messages = [
                "user_id" => [
                    "required" => "{field} tidak boleh kosong",
                ],
                "testimoni" => [
                    "required" => "{field} tidak boleh kosong",
                    "max_length" => "{field} maksimal 255 karakter",
                ],
            ];

            if($this->validate($rules, $messages)) {
                $dataUserVideo = [
                    'user_id' => $this->request->getVar('user_id'),
                    'testimoni' => $this->request->getVar('testimoni'),
                ];
                $this->testimoni->insert($dataUserVideo);

                $response = [
                    'status'   => 201,
                    'success'    => 201,
                    'messages' => [
                        'success' => 'Testimoni berhasil dibuat'
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
            return $this->fail('Akses token tidak sesuai');
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
            if($data['role'] != 'admin'){
                return $this->fail('Tidak dapat di akses selain admin', 400);
            }

            $input = $this->request->getRawInput();

            $rules = [
                'user_id' => 'required',
                'testimoni' => 'required|max_length[255]'
            ];

            $messages = [
                "user_id" => [
                    "required" => "{field} tidak boleh kosong",
                ],
                "testimoni" => [
                    "required" => "{field} tidak boleh kosong",
                    "max_length" => "{field} maksimal 255 karakter",
                ],
            ];

            $data = [
                "user_id" => $input["user_id"],
                "testimoni" => $input["testimoni"],
            ];

            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Testimoni berhasil diperbarui'
                ]
            ];

            $cek = $this->testimoni->where('testimoni_id', $id)->findAll();

            if(!$cek){
                return $this->failNotFound('Data Testimoni tidak ditemukan');
            }

            if (!$this->validate($rules, $messages)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            if ($this->testimoni->update($id, $data)){
                return $this->respond($response);
            }
        } catch (\Throwable $th) {
            return $this->fail('Akses token tidak sesuai');
        }
		return $this->failNotFound('Data Testimoni tidak ditemukan');
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
            if($data['role'] != 'admin'){
                return $this->fail('Tidak dapat di akses selain admin', 400);
            }

            $data = $this->testimoni->where('testimoni_id', $id)->findAll();
            if($data){
            $this->testimoni->delete($id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Testimoni berhasil dihapus'
                    ]
                ];
            }
            return $this->respondDeleted($response);
        } catch (\Throwable $th) {
            return $this->fail('Akses token tidak sesuai');
        }
        return $this->failNotFound('Data Testimoni tidak ditemukan');
    }
}
