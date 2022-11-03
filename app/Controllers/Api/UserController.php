<?php

namespace App\Controllers\Api;

use App\Models\Cart;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Users;
use App\Models\Jobs;
use App\Models\Notification;
use App\Models\UserCourse;
use App\Models\Course;
use Firebase\JWT\JWT;

class UserController extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);
            $user = new Users;

            $data = $user->select('role')->where('id', $decoded->uid)->first();
            if ($data['role'] != 'admin') {
                return $this->fail('Tidak dapat di akses selain admin', 400);
            }

            $data = $user->orderBy('id', 'DESC')->findAll();
            return $this->respond($data);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

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
            $modelUserCourse = new UserCourse;
            $modelCourse = new Course;

            $data = $user->where('id', $decoded->uid)->first();
            $job_data = $job->where('job_id', $data['job_id'])->first();

            $path = site_url() . 'upload/users/';

            $userCourse = $modelUserCourse->where('user_id', $decoded->uid)->findAll();

            $course = $userCourse;
            for ($i = 0; $i < count($userCourse); $i++) {
                $course_ = $modelCourse->where('course_id', $userCourse[$i]['course_id'])->first();
                $course[$i] = $course_;
            }

            $response = [
                'id' => $decoded->uid,
                'profile_picture' => $path . $data['profile_picture'],
                'fullname' =>  $data['fullname'],
                'email' => $decoded->email,
                'date_birth' => $data['date_birth'],
                'job_name' => (is_null($data['job_id'])) ? null : $job_data['job_name'],
                'address' => $data['address'],
                'phone_number' => $data['phone_number'],
                'linkedin' => $data['linkedin'],
                'course' => $course
            ];
            return $this->respond($response);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data user tidak ditemukan');
    }

    // TODO: Opsi untuk user ketika ingin menghapus foto profile dan otomatis terganti ke default
    public function update($id = null)
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        $decoded = JWT::decode($token, $key, ['HS256']);
        $id = $decoded->uid;

        try {
            $user = new Users;
            $cek = $user->where('id', $id)->findAll();

            $rules = [
                'fullname' => 'required',
                'date_birth' => 'required|valid_date',
                'phone_number' => 'required|numeric',
                'profile_picture' => 'uploaded[profile_picture]'
                    . '|is_image[profile_picture]'
                    . '|mime_in[profile_picture,image/jpg,image/jpeg,image/png,image/webp]'
                    . '|max_size[profile_picture,4000]'
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
                'profile_pciture' => [
                    'uploaded' => '{field} tidak boleh kosong',
                    'mime_in' => 'File Extention Harus Berupa png, jpg, atau jpeg',
                    'max_size' => 'Ukuran File Maksimal 4 MB'
                ],
            ];

            if ($this->validate($rules, $messages)) {
                $profilePicture = $this->request->getFile('profile_picture');
                if (is_null($profilePicture)) {
                    $fileName = $cek['profile_picture'];
                } else {
                    $fileName = $profilePicture->getRandomName();
                }

                $data = [
                    'fullname' => $this->request->getVar('fullname'),
                    'job_id' => $this->request->getVar('job_id'),
                    'address' => $this->request->getVar('address'),
                    'date_birth' => $this->request->getVar('date_birth'),
                    'phone_number' => $this->request->getVar('phone_number'),
                    'linkedin' => $this->request->getVar('linkedin'),
                    'profile_picture' => $fileName,
                ];
                $profilePicture->move('upload/users/', $fileName);
                $user->update($id, $data);

                $response = [
                    'status'   => 201,
                    'success'    => 201,
                    'messages' => [
                        'success' => 'Profil berhasil diupdate'
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
            if (!$cek) {
                return $this->failNotFound('Data user tidak ditemukan');
            }

            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data user tidak ditemukan');
    }

    // public function jobs()
    // {
    //     $key = getenv('TOKEN_SECRET');
    //     $header = $this->request->getServer('HTTP_AUTHORIZATION');
    //     if (!$header) return $this->failUnauthorized('Akses token diperlukan');
    //     $token = explode(' ', $header)[1];

    //     try {
    //         $decoded = JWT::decode($token, $key, ['HS256']);
    //         $job = new Jobs;
    //         $data = $job->select('job_id, job_name')->findAll();
    //         if ($data) {
    //             return $this->respond($data);
    //         } else {
    //             return $this->failNotFound('Data pekerjaan tidak ditemukan');
    //         }
    //     } catch (\Throwable $th) {
    //         return $this->fail($th->getMessage());
    //     }
    // }

    public function delete($id = null)
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);
            $user = new Users;
            $cart = new Cart;
            $notification = new Notification;

            // cek role user
            $data = $user->select('role')->where('id', $decoded->uid)->first();
            if ($data['role'] != 'admin') {
                return $this->fail('Tidak dapat di akses selain admin', 400);
            }

            $data = $user->where('id', $id)->findAll();
            if ($data) {
                $cart->delete($data);
                $notification->delete($data);
                $user->delete($id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'User berhasil dihapus'
                    ]
                ];
                return $this->respondDeleted($response);
            } else {
                return $this->failNotFound('Data User tidak ditemukan');
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data User tidak ditemukan');
    }
}
