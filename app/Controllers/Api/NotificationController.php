<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Notification;
use App\Models\Users;
use CodeIgniter\HTTP\RequestInterface;
use Firebase\JWT\JWT;
use CodeIgniter\API\ResponseTrait;

class NotificationController extends ResourceController
{
    use ResponseTrait;
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);
            $user = new Users;
            $model = new Notification();
            $data = [];
            $data = $user->select('id')->where('id', $decoded->uid)->first();
            $public_notification = $model->where('user_id', null)->findAll();
            $private_notification = $model->where('user_id', $data['id'])->findAll();

            $data['notification'] = [];
            if(count($private_notification) != 0){
                for($i = 0; $i < count($private_notification); $i++){
                    array_push($data['notification'], $private_notification[$i]);
                }
            }
            if(count($public_notification) != 0){
                for($i = 0; $i < count($public_notification); $i++){
                    array_push($data['notification'], $public_notification[$i]);
                }
            }

            rsort($data['notification']);

            return $this->respond($data);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data user tidak ditemukan');
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
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

            $data = $user->select('role')->where('id', $decoded->uid)->first();
            if ($data['role'] == 'member' || $data['role'] == 'partner' || $data['role'] == 'mentor') {
				return $this->fail('Tidak dapat di akses selain admin & author', 400);
			}

            $model = new Notification();

            $rules = [
                'message' => 'required|min_length[8]',
            ];

            $messages = [
                "message" => [
                    "required" => "{field} tidak boleh kosong",
                    'min_length' => '{field} minimal 8 karakter'
                ],
            ];

            $response;
            if($this->validate($rules, $messages)) {
                if($this->request->getVar('user_id')){
                    $data = [
                      'user_id' => $this->request->getVar('user_id'),
                      'message' => $this->request->getVar('message'),
                    ];
                }else{
                    $data = [
                      'message' => $this->request->getVar('message'),
                    ];
                }

                $model->insert($data);

                $response = [
                    'status'   => 201,
                    'success'    => 201,
                    'messages' => [
                        'success' => 'Notification berhasil dibuat'
                    ]
                ];
            }else{
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
        return $this->failNotFound('Data user tidak ditemukan');
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

            $data = $user->select('role')->where('id', $decoded->uid)->first();
            if ($data['role'] == 'member' || $data['role'] == 'partner' || $data['role'] == 'mentor') {
				return $this->fail('Tidak dapat di akses selain admin & author', 400);
			}

            $model = new Notification();

            $rules = [
                'message' => 'required|min_length[8]',
            ];

            $messages = [
                "message" => [
                    "required" => "{field} tidak boleh kosong",
                    'min_length' => '{field} minimal 8 karakter'
                ],
            ];

            $response;
            if($model->find($id)){
                if($this->validate($rules, $messages)) {
                    if($this->request->getRawInput('user_id')){
                        $data = [
                        'user_id' => $this->request->getRawInput('user_id'),
                        'message' => $this->request->getRawInput('message'),
                        ];
                    }else{
                        $data = [
                        'message' => $this->request->getRawInput('message'),
                        ];
                    }
                    $model->update($id, $data['user_id']);

                    $response = [
                        'status'   => 201,
                        'success'    => 201,
                        'messages' => [
                            'success' => 'Notification berhasil di perbarui'
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
        return $this->failNotFound('Data user tidak ditemukan');
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

            $data = $user->select('role')->where('id', $decoded->uid)->first();
            if ($data['role'] == 'member' || $data['role'] == 'partner' || $data['role'] == 'mentor') {
				return $this->fail('Tidak dapat di akses selain admin & author', 400);
			}

            $model = new Notification();

            if($model->find($id)){
                $model->delete($id);

                $response = [
                    'status'   => 200,
                    'success'    => 200,
                    'messages' => [
                        'success' => 'Notification berhasil di hapus'
                    ]
                ];
                return $this->respondDeleted($response);
            }else{
                return $this->failNotFound('Data tidak di temukan');
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data user tidak ditemukan');
    }
}
