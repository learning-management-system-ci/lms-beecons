<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Bundling;
use App\Models\Users;
use Firebase\JWT\JWT;

class BundlingController extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->bundling = new Bundling();
    }

    public function index(){
        $data['bundling'] = $this->bundling->orderBy('bundling_id', 'DESC')->findAll();
        return $this->respond($data);
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
                "category_id" => "required",
                "title" => "required",
                "description" => "required|max_length[255]",
                "old_price" => "required|numeric",
                "new_price" => "required|numeric",
            ];
    
            $messages = [
                "category_id" => [
                    "required" => "{field} tidak boleh kosong"
                ],
                "title" => [
                    "required" => "{field} tidak boleh kosong"
                ],
                "description" => [
                    "required" => "{field} tidak boleh kosong",
                    "max_length" => "{field} maksimal 255 karakter",
                ],
                "new_price" => [
                    "required" => "{field} tidak boleh kosong",
                    "numeric" => "{field} harus berisi angka"
                ],
                "old_price" => [
                    "required" => "{field} tidak boleh kosong",
                    "numeric" => "{field} harus berisi angka"
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
                $data['category_id'] = $this->request->getVar("category_id");
                $data['title'] = $this->request->getVar("title");
                $data['description'] = $this->request->getVar("description");
                $data['new_price'] = $this->request->getVar("new_price");
                $data['old_price'] = $this->request->getVar("old_price");
    
                $this->bundling->save($data);
    
                $response = [
                    'status' => 200,
                    'error' => false,
                    'message' => 'Bundling berhasil dibuat',
                    'data' => []
                ];
            }
            return $this->respondCreated($response);
	    } catch (\Throwable $th) {
            return $this->fail('Akses token tidak sesuai');
        }
    }

    public function show($id = null){
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
		    $decoded = JWT::decode($token, $key, ['HS256']);
            $data = $this->bundling->where('bundling_id', $id)->first();
            if($data){
                return $this->respond($data);
            }else{
                return $this->failNotFound('Data bundling tidak ditemukan');
            }
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
                "category_id" => "required",
                "title" => "required",
                "description" => "required|max_length[255]",
                "new_price" => "required|numeric",
                "old_price" => "required|numeric",
            ];
            $messages = [
                "category_id" => [
                    "required" => "{field} tidak boleh kosong"
                ],
                "title" => [
                    "required" => "{field} tidak boleh kosong"
                ],
                "description" => [
                    "required" => "{field} tidak boleh kosong",
                    "max_length" => "{field} maksimal 255 karakter",
                ],
                "old_price" => [
                    "required" => "{field} tidak boleh kosong",
                    "numeric" => "{field} harus berisi angka"
                ],
                "new_price" => [
                    "required" => "{field} tidak boleh kosong",
                    "numeric" => "{field} harus berisi angka"
                ],
            ];

            $data = [
                "category_id" => $input["category_id"],
                "title" => $input["title"],
                "description" => $input["description"],
                "new_price" => $input["new_price"],
                "old_price" => $input["old_price"],
            ];
    
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Bundling berhasil diperbarui'
                ]
            ];
    
            $cek = $this->bundling->where('bundling_id', $id)->findAll();
            if(!$cek){
                return $this->failNotFound('Data bundling tidak ditemukan');
            }

	    	if (!$this->validate($rules, $messages)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }
          
            if ($this->bundling->update($id, $data)){
                return $this->respond($response);
            }
            return $this->failNotFound('Data bundling tidak ditemukan');
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

            $data = $this->bundling->where('bundling_id', $id)->findAll();
            if($data){
            $this->bundling->delete($id);
                $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Bundling berhasil dihapus'
                ]
                ];
                return $this->respondDeleted($response);
            }else{
                return $this->failNotFound('Data bundling tidak ditemukan');
            }
	    } catch (\Throwable $th) {
            return $this->fail('Akses token tidak sesuai');
        }
    }
}
