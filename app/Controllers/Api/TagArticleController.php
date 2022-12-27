<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\TagArticle;
use App\Models\Users;
use Firebase\JWT\JWT;

class TagArticleController extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->tagarticle = new TagArticle();
    }
    
    public function index() {
        $data = $this->tagarticle->orderBy('tag_article_id', 'DESC')->findAll();

        if (count($data) > 0) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data Tag Artikel tidak ditemukan');
        }
    }

    public function show($id = null){
        $data = $this->tagarticle->where('tag_article_id', $id)->first();
        
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Data Tag Artikel tidak ditemukan');
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
            if ($data['role'] == 'member') {
                return $this->fail('Tidak dapat di akses oleh member', 400);
            }

            $rules = [
                "name_tag" => "required|max_length[255]",
            ];
    
            $messages = [
                "name_tag" => [
                    "required" => "{field} tidak boleh kosong",
                    "max_length" => "{field} maksimal 255 karakter",
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
                $data['name_tag'] = $this->request->getVar("name_tag");
    
                $this->tagarticle->save($data);
    
                $response = [
                    'status' => 200,
                    'error' => false,
                    'message' => 'Data Tag Artikel berhasil dibuat',
                    'data' => []
                ];
            }
            return $this->respondCreated($response);
	    } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
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
            if ($data['role'] == 'member') {
                return $this->fail('Tidak dapat di akses oleh member', 400);
            }

            $input = $this->request->getRawInput();

            $rules = [
                "name_tag" => "required|max_length[255]",
            ];
    
            $messages = [
                "name_tag" => [
                    "required" => "{field} tidak boleh kosong",
                    "max_length" => "{field} maksimal 255 karakter",
                ],
            ];

            $data = [
                "name_tag" => $input["name_tag"],
            ];
    
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Data Tag Artikel berhasil diperbarui'
                ]
            ];
    
            $cek = $this->tagarticle->where('tag_article_id', $id)->findAll();
            if(!$cek){
                return $this->failNotFound('Data Tag Artikel tidak ditemukan');
            }

	    	if (!$this->validate($rules, $messages)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }
          
            if ($this->tagarticle->update($id, $data)){
                return $this->respond($response);
            }
        } catch (\Throwable $th) {
            exit($th->getMessage());
        }
        return $this->failNotFound('Data Tag Artikel tidak ditemukan');
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
            if ($data['role'] == 'member') {
                return $this->fail('Tidak dapat di akses oleh member', 400);
            }

            $data = $this->tagarticle->where('tag_article_id', $id)->findAll();
            if($data){
                $this->tagarticle->delete($id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Data Tag Artikel berhasil dihapus'
                    ]
                ];
            }
            return $this->respondDeleted($response);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data Tag Artikel tidak ditemukan');
    }
}
