<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Tag;
use App\Models\Users;
use CodeIgniter\HTTP\RequestInterface;
use Firebase\JWT\JWT;


class TagController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $model = new Tag();
        $data = $model->orderBy('tag_id', 'DESC')->findAll();

        if(count($data) > 0){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada data');
        }
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $model = new Tag();

        if($model->find($id)){
            $data = $model->where('tag_id', $id)->first();
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada data');
        }
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
            if ($data['role'] == 'member' || $data['role'] == 'partner' || $data['role'] == 'mentor') {
                return $this->fail('Tidak dapat di akses selain admin & author', 400);
            }

            $model = new Tag();

            $rules = [
                'name' => 'required',
            ];

            $messages = [
                "name" => [
                    "required" => "{field} tidak boleh kosong",
                ],
            ];

            if($this->validate($rules, $messages)) {
                $data = [
                'name' => $this->request->getVar('name'),
                ];

                $model->insert($data);
                $response = [
                    'status'   => 201,
                    'success'    => 201,
                    'messages' => [
                        'success' => 'Tag berhasil dibuat'
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
            if ($data['role'] == 'member' || $data['role'] == 'partner' || $data['role'] == 'mentor') {
                return $this->fail('Tidak dapat di akses selain admin & author', 400);
            }

            $model = new Tag();

            $rules = [
                'name' => 'required',
            ];

            $messages = [
                "name" => [
                    "required" => "{field} tidak boleh kosong",
                ],
            ];

            if($model->find($id)){
                if($this->validate($rules, $messages)) {
                    $data = [
                    'name' => $this->request->getRawInput('name'),
                    ];

                    $model->update($id, $data['name']);
                    $response = [
                        'status'   => 201,
                        'success'    => 201,
                        'messages' => [
                            'success' => 'Tag berhasil di perbarui'
                        ]
                    ];
                }else{
                    $response = [
                        'status'   => 400,
                        'error'    => 400,
                        'messages' => $this->validator->getErrors(),
                    ];
                }
            }else{
                $response = [
                    'status'   => 400,
                    'error'    => 400,
                    'messages' => 'Data tidak ditemukan',
                ];
            }
            return $this->respondCreated($response);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
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
            if ($data['role'] == 'member' || $data['role'] == 'partner' || $data['role'] == 'mentor') {
                return $this->fail('Tidak dapat di akses selain admin & author', 400);
            }

            $model = new Tag();

            if($model->find($id)){
                $model->delete($id);
                $response = [
                    'status'   => 200,
                    'success'    => 200,
                    'messages' => [
                        'success' => 'Tag berhasil di hapus'
                    ]
                ];
                return $this->respondDeleted($response);
            }else{
                return $this->failNotFound('Data tidak di temukan');
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
