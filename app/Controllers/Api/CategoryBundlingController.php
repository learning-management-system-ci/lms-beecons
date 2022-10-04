<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CategoryBundling;
use App\Models\Users;
use Firebase\JWT\JWT;

class CategoryBundlingController extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->categorybundling = new CategoryBundling();
    }
    
    public function index() {
        $data = $this->categorybundling->orderBy('category_bundling_id', 'DESC')->findAll();

        if (count($data) > 0) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Tidak category bundling ada data');
        }
    }

    public function show($id = null){
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
		    $decoded = JWT::decode($token, $key, ['HS256']);
            $data = $this->categorybundling->where('category_bundling_id', $id)->first();
            if($data){
                return $this->respond($data);
            }else{
                return $this->failNotFound('Data category bundling tidak ditemukan');
            }
	    } catch (\Throwable $th) {
            return $this->fail('Akses token tidak sesuai');
        }
    }

    public function create() {
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
                "name" => "required",
            ];
    
            $messages = [
                "name" => [
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
                $data['name'] = $this->request->getVar("name");
    
                $this->categorybundling->save($data);
    
                $response = [
                    'status' => 200,
                    'error' => false,
                    'message' => 'Data Category Bundling berhasil dibuat',
                    'data' => []
                ];
            }
            return $this->respondCreated($response);
	    } catch (\Throwable $th) {
            return $this->fail('Akses token tidak sesuai');
        }
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
                "name" => "required",
            ];
            $messages = [
                "name" => [
                    "required" => "{field} tidak boleh kosong"
                ],
            ];

            $data = [
                "name" => $input["name"],
            ];
    
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Category Bundling berhasil diperbarui'
                ]
            ];
    
            $cek = $this->categorybundling->where('cotegory_bundling_id', $id)->findAll();
            if(!$cek){
                return $this->failNotFound('Data Category Bundling tidak ditemukan');
            }

	    	if (!$this->validate($rules, $messages)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }
          
            if ($this->categorybundling->update($id, $data)){
                return $this->respond($response);
            }
            return $this->failNotFound('Data Category Bundling tidak ditemukan');
        } catch (\Throwable $th) {
            return $this->fail('Akses token tidak sesuai');
        }
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

            $data = $this->categorybundling->where('cotegory_bundling_id', $id)->findAll();
            if($data){
            $this->categorybundling->delete($id);
                $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Data Category Bundling berhasil dihapus'
                ]
                ];
                return $this->respondDeleted($response);
            }else{
                return $this->failNotFound('Data Category Bundling tidak ditemukan');
            }
	    } catch (\Throwable $th) {
            return $this->fail('Akses token tidak sesuai');
        }
    }
}
