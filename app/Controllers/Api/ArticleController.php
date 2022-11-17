<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Article;
use App\Models\TagArticle;
use App\Models\Users;
use Firebase\JWT\JWT;

class ArticleController extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->article = new Article();
        $this->tagarticle = new TagArticle();
    }

    public function index(){
        $data['article'] = $this->article->findAll();
        return $this->respond($data);
    }
    
    public function show($id = null){
        $data = $this->article->where('article_id', $id)->first();
        $tag_article_data = $this->tagarticle->where('tag_article_id', $data['tag_article_id'])->first();

        $path = site_url() . 'upload/article/';

        $response = [
            "article_id" => $data['article_id'],
            "name_tag" => (is_null($data['tag_article_id'])) ? null : $tag_article_data['name_tag'],
            "title" =>  $data['title'],
            "sub_title" => $data['sub_title'],
            "content" => $data['content'],
            "content_image" => $path . $data['content_image'],
            "created_at" => $data['created_at'],
            "updated_at" => $data['updated_at'],
        ];
        
        if($response){
            return $this->respond($response);
        }else{
            return $this->failNotFound('Data Artikel tidak ditemukan');
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
                'tag_article_id' => 'required|max_length[255]',
                'title' => 'required|max_length[255]',
                'sub_title' => 'required|max_length[255]',
                'content' => 'required|max_length[10000]',
                'content_image' => 'uploaded[content_image]'
                    . '|is_image[content_image]'
                    . '|mime_in[content_image,image/jpg,image/jpeg,image/png,image/webp]'
                    . '|max_size[content_image,4000]'
            ];

            $messages = [
                "tag_article_id" => [
                    "required" => "{field} tidak boleh kosong",
                ],
                "title" => [
                    "required" => "{field} tidak boleh kosong",
                    "max_length" => "{field} maksimal 255 karakter",
                ],
                "sub_title" => [
                    "required" => "{field} tidak boleh kosong",
                    "max_length" => "{field} maksimal 255 karakter",
                ],
                "content" => [
                    "required" => "{field} tidak boleh kosong",
                    "max_length" => "{field} maksimal 10000 karakter",
                ],
                'content_image' => [
                    'uploaded' => '{field} tidak boleh kosong',
                    'mime_in' => 'File Extention Harus Berupa png, jpg, atau jpeg',
                    'max_size' => 'Ukuran File Maksimal 4 MB'
                ],
            ];

            if($this->validate($rules, $messages)) {
                $datacontent_image = $this->request->getFile('content_image');
                $fileName = $datacontent_image->getRandomName();
                
                $data = [
                    'tag_article_id' => $this->request->getVar('tag_article_id'),
                    'title' => $this->request->getVar('title'),
                    'sub_title' => $this->request->getVar('sub_title'),
                    'content' => $this->request->getVar('content'),
                    'content_image' => $fileName,
                ];
                $datacontent_image->move('upload/article/', $fileName);
                
                $this->article->update($data);

                $response = [
                    'status'   => 201,
                    'success'    => 201,
                    'messages' => [
                        'success' => 'Data Artikel berhasil dibuat'
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
            if($data['role'] != 'admin'){
                return $this->fail('Tidak dapat di akses selain admin', 400);
            }

            $cek = $this->article->where('article_id', $id)->findAll();

            if (!$cek) {
                return $this->failNotFound('Data Article tidak ditemukan');
            }

            $rules_a = [
                'tag_article_id' => 'required|max_length[255]',
                'title' => 'required|max_length[255]',
                'sub_title' => 'required|max_length[255]',
                'content' => 'required|max_length[10000]'
            ];
            
            $rules_b = [
                'content_image' => 'uploaded[content_image]'
                . '|is_image[content_image]'
                . '|mime_in[content_image,image/jpg,image/jpeg,image/png,image/webp]'
                . '|max_size[content_image,4000]'
            ];

            $messages_a = [
                "tag_article_id" => [
                    "required" => "{field} tidak boleh kosong",
                ],
                "title" => [
                    "required" => "{field} tidak boleh kosong",
                    "max_length" => "{field} maksimal 255 karakter",
                ],
                "sub_title" => [
                    "required" => "{field} tidak boleh kosong",
                    "max_length" => "{field} maksimal 255 karakter",
                ],
                "content" => [
                    "required" => "{field} tidak boleh kosong",
                    "max_length" => "{field} maksimal 10000 karakter",
                ]
            ];

            $messages_b = [
                'content_image' => [
                    'uploaded' => '{field} tidak boleh kosong',
                    'mime_in' => 'File Extention Harus Berupa png, jpg, atau jpeg',
                    'max_size' => 'Ukuran File Maksimal 4 MB'
                ],
            ];
            
            if ($this->validate($rules_a, $messages_a)) {
                if ($this->validate($rules_b, $messages_b)){
                    $datacontent_image = $this->request->getFile('content_image');
                    $fileName = $datacontent_image->getRandomName();
                    $data = [
                        'tag_article_id' => $this->request->getVar('tag_article_id'),
                        'title' => $this->request->getVar('title'),
                        'sub_title' => $this->request->getVar('sub_title'),
                        'content' => $this->request->getVar('content'),
                        'content_image' => $fileName,
                    ];
                    $datacontent_image->move('upload/article/', $fileName);
                    $this->article->update($id, $data);
                    
                    $response = [
                        'status'   => 201,
                        'success'    => 201,
                        'messages' => [
                            'success' => 'Data Article berhasil diupdate'
                        ]
                    ];
                } else {
                    $response = [
                        'status'   => 400,
                        'error'    => 400,
                        'messages' => $this->validator->getErrors(),
                    ];
                }
                $data = [
                    'tag_article_id' => $this->request->getVar('tag_article_id'),
                    'title' => $this->request->getVar('title'),
                    'sub_title' => $this->request->getVar('sub_title'),
                    'content' => $this->request->getVar('content')
                ];

                $this->article->update($id, $data);
                
                $response = [
                    'status'   => 201,
                    'success'    => 201,
                    'messages' => [
                        'success' => 'Data Article berhasil diupdate'
                    ]
                ];
            } else {
                $response = [
                    'status'   => 400,
                    'error'    => 400,
                    'messages' => $this->validator->getErrors(),
                ];
            }

            return $this->respondCreated($response);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data Article tidak ditemukan');
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

            $data = $this->article->where('article_id', $id)->findAll();
            if($data){
            $this->article->delete($id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Data Article berhasil dihapus'
                    ]
                ];
            }
            return $this->respondDeleted($response);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data Article tidak ditemukan');
    }
}