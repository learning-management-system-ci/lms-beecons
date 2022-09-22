<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Users;
use App\Models\Jobs;
use Firebase\JWT\JWT;

class UserController extends ResourceController
{

    use ResponseTrait;



    public function profile()
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);
            $user = new Users;
            $job = new Jobs;
            $data = $user->where('id', $decoded->uid)->first();
            $job_data = $job->where('job_id', $data['job_id'])->first();

            $response = [
                'id' => $decoded->uid,
                'profile_picture' => $data['profile_picture'],
                'fullname' =>  $data['fullname'],
                'email' => $decoded->email,
                'date_birth' => $data['date_birth'],
                'job_name' => (is_null($data['job_id'])) ? null : $job_data['job_name'],
                'address' => $data['address'],
                'phone_number' => $data['phone_number'],
                'linkedin' => $data['linkedin'],
            ];
            return $this->respond($response);
        } catch (\Throwable $th) {
            return $this->fail('Akses token tidak sesuai');
        }
        return $this->failNotFound('Data user tidak ditemukan');
    }

    public function update($id = null)
    {
        $input = $this->request->getRawInput();
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);
            $user = new Users;
            $cek = $user->where('id', $id)->findAll();

            $rules = [
                'fullname' => 'required',
                'date_birth' => 'required|valid_date',
                'phone_number' => 'required|numeric',
                'password' => 'min_length[4]|max_length[50]',
                'password_confirm' => 'matches[password]',
            ];

            $messages = [
                'fullname' => ['required' => '{field} tidak boleh kosong'],
                'date_birth' => [
                    'required' => '{field} tidak boleh kosong',
                    'valid_date' => '{field} format tanggal tidak sesuai'
                ],
                'phone_number' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} harus berisi numerik'
                ],
                'password' => [
                    'min_length' => '{field} minimal 4 karakter',
                    'max_length' => '{field} maksimal 50 karakter'
                ],
                'password_confirm' => [
                    'matches' => 'Konfirmasi kata sandi tidak cocok dengan kata sandi'
                ],
            ];

            $data = [
                'profile_picture' => $input['profile_picture'],
                'fullname' => $input['fullname'],
                'job_id' => $input['job'],
                'address' => $input['address'],
                'date_birth' => $input['date_birth'],
                'phone_number' => $input['phone_number'],
                'linkedin' => $input['linkedin'],
                'password' => password_hash($input['password'], PASSWORD_BCRYPT),
            ];

            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Profil berhasil diupdate'
                ]
            ];

            if (!$cek) {
                return $this->failNotFound('Data user tidak ditemukan');
            }

            if (!$this->validate($rules, $messages)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            if ($user->update($id, $data)) {
                return $this->respond($response);
            }
        } catch (\Throwable $th) {
            return $this->fail('Akses token tidak sesuai');
        }
        return $this->failNotFound('Data user tidak ditemukan');
    }

    public function jobs()
    {
        $job = new Jobs;
        $data = $job->select('job_id, job_name')->findAll();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data pekerjaan tidak ditemukan');
        }
    }
}
