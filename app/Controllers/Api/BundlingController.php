<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Bundling;
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
            $rules = [
                "title" => "required",
                "description" => "required|max_length[255]",
                "price" => "required|numeric",
            ];
    
            $messages = [
                "title" => [
                    "required" => "{field} tidak boleh kosong"
                ],
                "description" => [
                    "required" => "{field} tidak boleh kosong",
                    "max_length" => "{field} maksimal 255 karakter",
                ],
                "price" => [
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
                $data['title'] = $this->request->getVar("title");
                $data['description'] = $this->request->getVar("description");
                $data['price'] = $this->request->getVar("price");
    
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
            $input = $this->request->getRawInput();
            $rules = [
                "title" => "required",
                "description" => "required|max_length[255]",
                "price" => "required|numeric",
            ];
            $messages = [
                "title" => [
                    "required" => "{field} tidak boleh kosong"
                ],
                "description" => [
                    "required" => "{field} tidak boleh kosong",
                    "max_length" => "{field} maksimal 255 karakter",
                ],
                "price" => [
                    "required" => "{field} tidak boleh kosong",
                    "numeric" => "{field} harus berisi angka"
                ],
            ];

            $data = [
                "title" => $input["title"],
                "description" => $input["description"],
                "price" => $input["price"],
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
