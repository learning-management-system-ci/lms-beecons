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
        $this->users = new Users();
        $this->path = site_url() . 'upload/users/';
    }

    public function index(){
        $testimoni = $this->testimoni->findAll();

        $data['testimoni'] = $testimoni;
        
        for ($i = 0; $i < count($testimoni); $i++) {
            $datatestimoni = $this->testimoni
                ->where('testimoni.testimoni_id', $testimoni[$i]['testimoni_id'])
                ->join('users', 'testimoni.user_id=users.id')
                ->select('users.id, users.fullname, users.email, users.profile_picture, users.created_at')
                ->findAll();
            
            for ($x = 0; $x < count($datatestimoni); $x++) {
                $datatestimoni[$x]['profile_picture'] = $this->path . $datatestimoni[$x]['profile_picture'];
            }
            
            $data['testimoni'][$i]['users'] = $datatestimoni;
        }


        return $this->respond($data);
    }
    
    public function show($id = null){
        $testimoni = $this->testimoni->where('testimoni_id', $id)->first();

        $data['testimoni'] = $testimoni;

        $datausers = $this->users
            ->where('id', $id)
            ->select('users.id, users.fullname, users.email, users.profile_picture, users.created_at')
            ->first();

        $datausers['profile_picture'] = $this->path . $datausers['profile_picture'];

        $data['testimoni']['users'] = $datausers;

        if($data){
            return $this->respond($data);
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
            if ($data['role'] == 'member') {
                return $this->fail('Tidak dapat di akses oleh member', 400);
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
            if ($data['role'] == 'member') {
                return $this->fail('Tidak dapat di akses oleh member', 400);
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
            return $this->fail($th->getMessage());
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
            if ($data['role'] == 'member') {
                return $this->fail('Tidak dapat di akses oleh member', 400);
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
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data Testimoni tidak ditemukan');
    }
}
