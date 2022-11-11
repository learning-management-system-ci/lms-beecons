<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Webinar;
use App\Models\Users;
use Firebase\JWT\JWT;

class WebinarController extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->webinar = new Webinar();
    }

    public function index()
    {
        $data['webinar'] = $this->webinar->findAll();
        return $this->respond($data);
    }

    public function show($id = null)
    {
        $data = $this->webinar->where('webinar_id', $id)->first();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data Webinar tidak ditemukan');
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
            if ($data['role'] == 'member' || $data['role'] == 'mentor') {
                return $this->fail('Tidak dapat di akses selain admin, partner & author', 400);
            }

            $rules = [
                'title' => 'required|min_length[8]',
                'webinar_type' => 'required',
                'description' => 'required|min_length[8]',
                'old_price' => 'required|numeric',
                'new_price' => 'permit_empty|numeric',
                'thumbnail' => 'uploaded[thumbnail]'
                    . '|is_image[thumbnail]'
                    . '|mime_in[thumbnail,image/jpg,image/jpeg,image/png,image/webp]'
                    . '|max_size[thumbnail,4000]'
            ];

            $messages = [
                "title" => [
                    "required" => "{field} tidak boleh kosong",
                    'min_length' => '{field} minimal 8 karakter'
                ],
                "webinar_type" => [
                    "required" => "{field} tidak boleh kosong",
                ],
                "description" => [
                    "required" => "{field} tidak boleh kosong",
                    'min_length' => '{field} minimal 8 karakter'
                ],
                "old_price" => [
                    "required" => "{field} tidak boleh kosong",
                    "numeric" => "{field} harus berisi nomor",
                ],
                "new_price" => [
                    "numeric" => "{field} harus berisi nomor",
                ],
                "thumbnail" => [
                    'uploaded' => '{field} tidak boleh kosong',
                    'mime_in' => 'File Extention Harus Berupa png, jpg, atau jpeg',
                    'max_size' => 'Ukuran File Maksimal 4 MB'
                ],
            ];

            if ($this->validate($rules, $messages)) {
                $dataThumbnail = $this->request->getFile('thumbnail');
                $fileName = $dataThumbnail->getRandomName();
                $dataWebinar = [
                    'title' => $this->request->getVar('title'),
                    'webinar_type' => $this->request->getVar('service'),
                    'description' => $this->request->getVar('description'),
                    'old_price' => $this->request->getVar('old_price'),
                    'new_price' => $this->request->getVar('new_price'),
                    'thumbnail' => $fileName,
                ];
                $dataThumbnail->move('upload/webinar/', $fileName);
                $this->webinar->insert($dataWebinar);

                $response = [
                    'status'   => 201,
                    'success'    => 201,
                    'messages' => [
                        'success' => 'Webinar berhasil dibuat'
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
    }

    public function update($id = null)
    {
    }

    public function delete($id = null)
    {
    }
}
