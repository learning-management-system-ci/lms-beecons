<?php

namespace App\Controllers\Api;

use App\Models\Cart;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Users;
use App\Models\Jobs;
use App\Models\Order;
use App\Models\Notification;
use App\Models\UserCourse;
use App\Models\Course;
use App\Models\VideoCategory;
use App\Models\Video;
use App\Models\UserVideo;
use Firebase\JWT\JWT;

class UserController extends ResourceController
{
    use ResponseTrait;

    public function userDetail($id = null)
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

            $job = new Jobs;
            $modelOrder = new Order;
            $modelUserCourse = new UserCourse;
            $modelCourse = new Course;
            $modelVideoCategory = new VideoCategory;
            $modelVideo = new Video;
            $modelUserVideo = new UserVideo;

            $data = $user->where('id', $id)->first();
            $job_data = $job->where('job_id', $data['job_id'])->first();

            $path = site_url() . 'upload/users/';

            $userCourse = $modelUserCourse->where('user_id', $id)->findAll();

            $course = [];
            $videoCategory = [];

            for ($i = 0; $i < count($userCourse); $i++) {
                $course_ = $modelCourse->where('course_id', $userCourse[$i]['course_id'])->first();
                $course[$i] = $course_;

                array_push($videoCategory, $modelVideoCategory
                    ->where('course_id', $userCourse[$i]['course_id'])
                    ->orderBy('video_category.video_category_id', 'DESC')
                    ->first());

                if (isset($videoCategory[0]) && $videoCategory[0]['title'] != '') {
                    $course[$i]['video_category'] = $videoCategory;
                }


                for ($l = 0; $l < count($videoCategory); $l++) {
                    $video = $modelVideo
                        ->where('video_category_id', $videoCategory[$l]['video_category_id'])
                        ->orderBy('order', 'ASC')
                        ->findAll();

                    if ($videoCategory[0]['title'] != '') {
                        $course[$i]['video_category'][$l]['video'] = $video;

                        for ($p = 0; $p < count($video); $p++) {
                            $user_video = $modelUserVideo
                                ->select('score')
                                ->where('user_id', $decoded->uid)
                                ->where('video_id', $video[$p]['video_id'])
                                ->findAll();
                            if ($user_video) {
                                $course[$i]['video_category'][$l]['video'][$p]['score'] = $user_video[0]['score'];
                            } else {
                                $course[$i]['video_category'][$l]['video'][$p]['score'] = null;
                            }
                        }
                    } else {
                        $course[$i]['video'] = $video;

                        for ($p = 0; $p < count($video); $p++) {
                            $user_video = $modelUserVideo
                                ->select('score')
                                ->where('user_id', $decoded->uid)
                                ->where('video_id', $video[$p]['video_id'])
                                ->findAll();
                            if ($user_video) {
                                $course[$i]['video'][$p]['score'] = $user_video[0]['score'];
                            } else {
                                $course[$i]['video'][$p]['score'] = null;
                            }
                        }
                    }
                }
            }

            $order = $modelOrder->where('user_id', $id)->findAll();
            $orderData = [];
            if ($order != NULL) {
                foreach ($order as $value) {
                    $orderData[] = [
                        'order_id' => $value['order_id'],
                        'gross_amount' => $value['gross_amount'],
                        'transaction_status' => $value['transaction_status'],
                        'order_time' => $value['created_at']
                    ];
                }
            }

            $response = [
                'id' => $id,
                'profile_picture' => $path . $data['profile_picture'],
                'fullname' =>  $data['fullname'],
                'email' => $data['email'],
                'date_birth' => $data['date_birth'],
                'job_name' => (is_null($data['job_id'])) ? null : $job_data['job_name'],
                'address' => $data['address'],
                'phone_number' => $data['phone_number'],
                'linkedin' => $data['linkedin'],
                'transaction' => $orderData,
                'course' => $course
            ];
            return $this->respond($response);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

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

                return $this->respondCreated($response);
            }
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
