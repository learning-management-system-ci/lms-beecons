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
                'role' => $data['role'],
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

            $job = new Jobs;

            $data = $user->findAll();

            $path = site_url() . 'upload/users/';

            $response = [];

            for ($i = 0; $i < count($data); $i++) {
                $job_data = $job->where('job_id', $data[$i]['job_id'])->first();
                if ($data[$i]['profile_picture'] == null) {
                    $profilenull = $path . "dafault.png";
                } else {
                    $profilenull = $path . $data[$i]['profile_picture'];
                }
                array_push($response, [
                    'id' => $data[$i]['id'],
                    'profile_picture' => $profilenull,
                    'fullname' =>  $data[$i]['fullname'],
                    'email' => $data[$i]['email'],
                    'role' => $data[$i]['role'],
                    'date_birth' => $data[$i]['date_birth'],
                    'job_name' => (is_null($data[$i]['job_id'])) ? null : $job_data['job_name'],
                    'address' => $data[$i]['address'],
                    'phone_number' => $data[$i]['phone_number'],
                    'linkedin' => $data[$i]['linkedin'],
                    "created_at" => $data[$i]['created_at'],
                    "updated_at" => $data[$i]['updated_at'],
                ]);
            }

            return $this->respond($response);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function getRole()
    {
        $data['role'] = ['admin', 'partner', 'author', 'member', 'mentor'];

        return $this->respond($data);
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
            $modelVideo = new Video;
            $modelVideoCategory = new VideoCategory;
            $modelUserVideo = new UserVideo;

            $data = $user->where('id', $decoded->uid)->first();
            $job_data = $job->where('job_id', $data['job_id'])->first();

            $path_profile = site_url() . 'upload/users/';

            $path_course = site_url() . 'upload/course/';

            $userCourse = $modelUserCourse->where('user_id', $decoded->uid)->findAll();

            $course = $userCourse;
            $score_raw = 0;
            $score_final = 0;
            for ($i = 0; $i < count($userCourse); $i++) {
                $course_ = $modelCourse->where('course_id', $userCourse[$i]['course_id'])->first();
                $course[$i] = $course_;
                $course[$i]['thumbnail'] = 'upload/course-video/thumbnail/' . $course[$i]['thumbnail'];

                $course[$i]['thumbnail'] = $path_course . $course_['thumbnail'];

                $videoCat_ = $modelVideoCategory->where('course_id', $userCourse[$i]['course_id'])->first();
                $video_ = $modelVideo->where('video_category_id', $videoCat_['video_category_id'])->findAll();

                $userVideo = 0;
                for($l = 0; $l < count($video_); $l++){
                    $userVideo_ = $modelUserVideo->where('user_id', $decoded->uid)->where('video_id', $video_[$l]['video_id'])->first();

                    if($userVideo_){
                        $userVideo++;

                        $score_raw += $userVideo_['score'];
                        $score_final = $score_raw / count($video_);

                        $course[$i]['score'] = $score_final;
                    }else{
                        $course[$i]['score'] = null;
                    }
                }
            }

            $response = [
                'id' => $decoded->uid,
                'profile_picture' => $path_profile . $data['profile_picture'],
                'fullname' =>  $data['fullname'],
                'email' => $decoded->email,
                'date_birth' => $data['date_birth'],
                'job_name' => (is_null($data['job_id'])) ? null : $job_data['job_name'],
                'address' => $data['address'],
                'phone_number' => $data['phone_number'],
                'linkedin' => $data['linkedin'],
                'create since' => $data['created_at'],
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

        try {
            $user = new Users;

            if ($decoded->uid != $id) {
                return $this->failNotFound('Parameters & Token user tidak sesuai');
            };

            $cek = $user->where('id', $decoded->uid)->findAll();

            if (!$cek) {
                return $this->failNotFound('Data user tidak ditemukan');
            }

            $rules_a = [
                'fullname' => 'required',
                'date_birth' => 'required|valid_date',
                'phone_number' => 'required|numeric',
                'linkedin'  => 'required|valid_url_strict[https]'
            ];

            $rules_b = [
                'profile_picture' => 'uploaded[profile_picture]'
                    . '|is_image[profile_picture]'
                    . '|mime_in[profile_picture,image/jpg,image/jpeg,image/png,image/webp]'
                    . '|max_size[profile_picture,4000]'
            ];

            $messages_a = [
                'fullname' => ['required' => '{field} tidak boleh kosong'],
                'date_birth' => [
                    'required' => '{field} tidak boleh kosong',
                    'valid_date' => '{field} format tanggal tidak sesuai'
                ],
                'phone_number' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} harus berisi numerik'
                ],
                'linkedin' => ['valid_url_strict' => 'Tolong masukkan link linkedin anda']
            ];

            $messages_b = [
                'profile_picture' => [
                    'uploaded' => '{field} tidak boleh kosong',
                    'mime_in' => 'File Extention Harus Berupa png, jpg, atau jpeg',
                    'max_size' => 'Ukuran File Maksimal 4 MB'
                ],
            ];


            if ($this->validate($rules_a, $messages_a)) {
                if ($this->validate($rules_b, $messages_b)) {

                    $oldThumbnail = $cek['profile_picture'];
                    $profilePicture = $this->request->getFile('profile_picture');

                    if ($profilePicture->isValid() && !$profilePicture->hasMoved()) {
                        if (file_exists("upload/users/" . $oldThumbnail)) {
                            unlink("upload/users/" . $oldThumbnail);
                        }
                        $fileName = $profilePicture->getRandomName();
                        $profilePicture->move('upload/users/', $fileName);
                    } else {
                        $fileName = $oldThumbnail['profile_picture'];
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
                $data = [
                    'fullname' => $this->request->getVar('fullname'),
                    'job_id' => $this->request->getVar('job_id'),
                    'address' => $this->request->getVar('address'),
                    'date_birth' => $this->request->getVar('date_birth'),
                    'phone_number' => $this->request->getVar('phone_number'),
                    'linkedin' => $this->request->getVar('linkedin'),
                ];

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
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data user tidak ditemukan');
    }

    public function updateUserByAdmin($id = null)
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        $decoded = JWT::decode($token, $key, ['HS256']);

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);
            $user = new Users;

            // cek role user
            $data = $user->select('role')->where('id', $decoded->uid)->first();
            if ($data['role'] != 'admin') {
                return $this->fail('Tidak dapat di akses selain admin', 400);
            }

            $cek = $user->where('id', $id)->findAll();

            if (!$cek) {
                return $this->failNotFound('Data user tidak ditemukan');
            }

            $rules_a = [
                'fullname' => 'required',
                'job_id' => 'required',
                'role' => 'required',
                'date_birth' => 'required|valid_date',
                'phone_number' => 'required|numeric',
                'address' => 'required',
            ];

            $rules_b = [
                'profile_picture' => 'uploaded[profile_picture]'
                    . '|is_image[profile_picture]'
                    . '|mime_in[profile_picture,image/jpg,image/jpeg,image/png,image/webp]'
                    . '|max_size[profile_picture,4000]'
            ];

            $messages_a = [
                'fullname' => ['required' => '{field} tidak boleh kosong'],
                'job_id' => ['required' => '{field} tidak boleh kosong'],
                'role' => ['required' => '{field} tidak boleh kosong'],
                'date_birth' => [
                    'required' => '{field} tidak boleh kosong',
                    'valid_date' => '{field} format tanggal tidak sesuai'
                ],
                'phone_number' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} harus berisi numerik'
                ],
                'address' => ['required' => '{field} tidak boleh kosong'],
            ];

            $messages_b = [
                'profile_picture' => [
                    'uploaded' => '{field} tidak boleh kosong',
                    'mime_in' => 'File Extention Harus Berupa png, jpg, atau jpeg',
                    'max_size' => 'Ukuran File Maksimal 4 MB'
                ],
            ];

            if ($this->validate($rules_a, $messages_a)) {
                if ($this->validate($rules_b, $messages_b)) {
                    $profilePicture = $this->request->getFile('profile_picture');
                    $fileName = $profilePicture->getRandomName();
                    $data = [
                        'fullname' => $this->request->getVar('fullname'),
                        'job_id' => $this->request->getVar('job_id'),
                        'role' => $this->request->getVar('role'),
                        'address' => $this->request->getVar('address'),
                        'date_birth' => $this->request->getVar('date_birth'),
                        'phone_number' => $this->request->getVar('phone_number'),
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
                $data = [
                    'fullname' => $this->request->getVar('fullname'),
                    'job_id' => $this->request->getVar('job_id'),
                    'role' => $this->request->getVar('role'),
                    'address' => $this->request->getVar('address'),
                    'date_birth' => $this->request->getVar('date_birth'),
                    'phone_number' => $this->request->getVar('phone_number'),
                ];

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
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data user tidak ditemukan');
    }

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

    public function learningProgress()
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);

            $modelUserCourse = new UserCourse;
            $modelUserVideo = new UserVideo;
            $modelVideoCategory = new VideoCategory;
            $modelVideo = new Video;

            $userCourse = $modelUserCourse->where('user_id', $decoded->uid)->findAll();

            for ($i = 0; $i < count($userCourse); $i++) {
                $videoCategory = $modelVideoCategory->where('course_id', $userCourse[$i]['course_id'])->first();
                $video = $modelVideo->where('video_category_id', $videoCategory['video_category_id'])->findAll();

                $completed = [];

                for ($j = 0; $j < count($video); $j++) {
                    $userVideo = $modelUserVideo->where('user_id', $decoded->uid)->where('video_id', $video[$j]['video_id'])->first();
                    if (isset($userVideo)) {
                        $completed[$j] = $userVideo;
                    } else {
                        continue;
                    }
                }

                $progress[$i] = [
                    'course_id' => $userCourse[$i]['course_id'],
                    'completed' => count($completed),
                    'total' => count($video)
                ];
            }

            $response = [
                'id' => $decoded->uid,
                'progress' => $progress
            ];
            return $this->respond($response);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}