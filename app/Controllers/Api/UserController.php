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
use App\Models\Bundling;
use App\Models\VideoCategory;
use App\Models\Video;
use App\Models\UserVideo;
use App\Models\CourseBundling;
use App\Models\Review;
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
            if ($data['role'] == 'member') {
                return $this->fail('Tidak dapat di akses oleh member', 400);
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
            $modelBundling = new Course;
            $modelVideo = new Video;
            $modelVideoCategory = new VideoCategory;
            $modelUserVideo = new UserVideo;
            $modelCourseBundling = new CourseBundling;
            $modelUserReview = new Review;

            $data = $user->where('id', $decoded->uid)->first();
            $job_data = $job->where('job_id', $data['job_id'])->first();

            $path_profile = site_url() . 'upload/users/';

            $path_course = site_url() . 'upload/course/thumbnail/';
            $path_bundling = site_url() . 'upload/bundling/';

            $userCourse = $modelUserCourse->where('user_id', $decoded->uid)
                ->where('bundling_id', NULL)
                ->findAll();

            $course = $userCourse;
            $score_raw = 0;
            $score_final = 0;
            for ($i = 0; $i < count($userCourse); $i++) {
                $userReview = $modelUserReview->where('user_id', $decoded->uid)
                    ->where('course_id', $userCourse[$i]['course_id'])
                    ->first();

                $course_ = $modelCourse->where('course_id', $userCourse[$i]['course_id'])->first();
                $course[$i] = $course_;
                $course[$i]['thumbnail'] = site_url() . 'upload/course-video/thumbnail/' . $course[$i]['thumbnail'];

                if ($userReview) {
                    $course[$i]['review'] = $userReview['score'];
                    $course[$i]['is_review'] = true;
                } else {
                    $course[$i]['is_review'] = false;
                }

                $course[$i]['thumbnail'] = $path_course . $course_['thumbnail'];

                $videoCat_ = $modelVideoCategory->where('course_id', $userCourse[$i]['course_id'])->first();
                $video_ = $modelVideo->where('video_category_id', $videoCat_['video_category_id'])->findAll();

                $userVideo = 0;

                $total_video_yang_dikerjakan = 0;
                $lolos = false;
                for ($l = 0; $l < count($video_); $l++) {
                    $userVideo_ = $modelUserVideo->where('user_id', $decoded->uid)->where('video_id', $video_[$l]['video_id'])->first();

                    if ($userVideo_) {
                        $userVideo++;
                        $total_video_yang_dikerjakan++;

                        $score_raw += $userVideo_['score'];
                        $score_final = $score_raw / count($video_);

                        $course[$i]['score'] = $score_final;
                    } else {
                        $course[$i]['score'] = null;
                    }
                }
                $course[$i]['mengerjakan_video'] = $total_video_yang_dikerjakan . ' / ' . count($video_);
                if ($total_video_yang_dikerjakan == count($video_)) {
                    $course[$i]['lolos'] = true;
                } else {
                    $course[$i]['lolos'] = false;
                }
            }

            $userBundling = $modelUserCourse->select('bundling.bundling_id, title, description, old_price, new_price, thumbnail')
                ->where('user_id', $decoded->uid)
                ->join('bundling', 'user_course.bundling_id=bundling.bundling_id')
                ->where('course_id', NULL)
                ->findAll();
            // var_dump($userBundling);
            // die;


            $response = [
                'id' => $decoded->uid,
                'profile_picture' => $path_profile . $data['profile_picture'],
                'fullname' => $data['fullname'],
                'email' => $decoded->email,
                'date_birth' => $data['date_birth'],
                'job_name' => (is_null($data['job_id'])) ? null : $job_data['job_name'],
                'address' => $data['address'],
                'phone_number' => $data['phone_number'],
                'linkedin' => $data['linkedin'],
                'created_at' => $data['created_at'],
                'course' => $course,
                'bundling' => [],
                //'bundling' => (array) array_merge((array) $userBundling[0], ['course_bundling' => $courseBundling]),
            ];

            if ($userBundling) {
                $courseBundling = [];
                // foreach ($userBundling as $key => $value) {
                for ($k = 0; $k < count($userBundling); $k++) {
                    $courseBundling_ = $modelCourseBundling->select('course.course_id, title, service, description, key_takeaways, suitable_for, old_price, new_price, thumbnail, author_id, course.created_at, course.updated_at')
                        ->join('course', 'course_bundling.course_id=course.course_id', 'right')
                        ->where('course_bundling.bundling_id', $userBundling[$k]['bundling_id'])
                        ->findAll();

                    $scoreBundling = 0;
                    $scoreBundlingRaw = [];
                    $total_video_yang_dikerjakan_raw = [];
                    $check_lolos_raw = [];

                    foreach ($courseBundling_ as $key => $courseBundling) {

                        $userReview = $modelUserReview
                            ->where('user_id', $decoded->uid)
                            ->where('course_id', $courseBundling['course_id'])
                            ->first();

                        if ($userReview) {
                            $courseBundling_[$key]['review'] = $userReview['score'];
                            $courseBundling_[$key]['is_review'] = true;
                        } else {
                            $courseBundling_[$key]['is_review'] = false;
                        }

                        $scoreCourseRaw = 0;
                        $scoreCourseRaw2 = [];

                        $videoCategory = $modelVideoCategory->where('course_id', $courseBundling['course_id'])->first();
                        $video = $modelVideo->where('video_category_id', $videoCategory['video_category_id'])->findAll();

                        $total_video_yang_dikerjakan = 0;
                        $dari = count($video);
                        foreach ($video as $key => $video_) {
                            $userVideo = $modelUserVideo->where('user_id', $decoded->uid)->where('video_id', $video_['video_id'])->first();

                            if ($userVideo) {
                                $total_video_yang_dikerjakan++;
                                array_push($scoreCourseRaw2, $userVideo['score']);
                                $scoreCourseRaw += $userVideo['score'];
                            }
                        }
                        array_push($total_video_yang_dikerjakan_raw, $total_video_yang_dikerjakan . ' / ' . $dari);

                        if ($total_video_yang_dikerjakan == count($video)) {
                            array_push($check_lolos_raw, true);
                        } else {
                            array_push($check_lolos_raw, false);
                        }

                        $scoreCourse = $scoreCourseRaw / count($video);
                        array_push($scoreBundlingRaw, $scoreCourse);
                    }

                    // return $this->respond($check_lolos_raw);
                    // return $this->respond($scoreBundlingRaw);
                    // foreach ($scoreBundlingRaw as $key => $value) {
                    for ($o = 0; $o < count($scoreBundlingRaw); $o++) {
                        $scoreBundling += $scoreBundlingRaw[$o];
                    }


                    $scoreBundling /= count($scoreBundlingRaw);

                    $userBundling[$k]['score'] = $scoreBundling;
                    // $userBundling[$k]['mengerjakan_video'] = $total_video_yang_dikerjakan_raw;
                    // $userBundling[$k]['lolos'] = $check_lolos_raw;


                    $userBundling[$k]['course_bundling'] = $courseBundling_;

                    for ($o = 0; $o < count($userBundling[$k]['course_bundling']); $o++) {
                        $userBundling[$k]['course_bundling'][$o]['score'] = $scoreBundlingRaw[$o];

                        $userBundling[$k]['course_bundling'][$o]['mengerjakan_video'] = $total_video_yang_dikerjakan_raw[$o];

                        $userBundling[$k]['course_bundling'][$o]['lolos'] = $check_lolos_raw[$o];
                    }
                }

                // $courseBundling['thumbnail'] = $path_bundling . $courseBundling['thumbnail'];

                // foreach ($courseBundling['course_bundling'] as $key => $value) {
                //     $courseBundling['course_bundling'][$key]['thumbnail'] = $path_course . $courseBundling['course_bundling'][$key]['thumbnail'];
                // }

                $response['bundling'] = $userBundling;
            }

            return $this->respond($response);
        } catch (\Throwable $th) {
            //throw $th;
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
                'progress' => isset($progress) ? $progress : [],
            ];
            return $this->respond($response);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function getAuthor()
    {
        $user = new Users;
        $modelCourse = new Course;
        $modelBundling = new Bundling;
        $modelReview = new Review;

        $path = site_url() . 'upload/users/';

        $getdataauthor = $user
            ->where('role', 'author')
            ->select('id, fullname, email, profile_picture, role, company')
            ->findAll();

        for ($c = 0; $c < count($getdataauthor); $c++) {
            $getdataauthor[$c]['profile_picture'] = $path . $getdataauthor[$c]['profile_picture'];
        }

        $data['author'] = $getdataauthor;

        $rating_author_raw = 0;
        $rating_author_final = 0;

        for ($i = 0; $i < count($getdataauthor); $i++) {
            $course = $modelCourse
                ->where('author_id', $getdataauthor[$i]['id'])
                ->select('course_id')
                ->findAll();

            $bundling = $modelBundling
                ->where('author_id', $getdataauthor[$i]['id'])
                ->select('bundling_id')
                ->findAll();

            $rating_course_raw = 0;
            $rating_course_final = 0;

            if ($course != null) {
                for ($x = 0; $x < count($course); $x++) {
                    $cek_course = $modelReview->where('course_id', $course[$x]['course_id'])->findAll();

                    if ($cek_course != null) {
                        $reviewcourse = $modelReview->where('course_id', $course[$x]['course_id'])->findAll();

                        $rating_raw = 0;
                        $rating_final = 0;

                        for ($n = 0; $n < count($reviewcourse); $n++) {
                            $rating_raw += $reviewcourse[$n]['score'];
                            $rating_final = $rating_raw / count($reviewcourse);

                            // $data['author'][$i]['course'][$x]['rating_course'] = $rating_final;
                        }

                        $rating_course_raw += $rating_final;
                        $rating_course_final = $rating_course_raw / count($course);
                        // $data['author'][$i]['course_final_rating'] = $rating_course_final;
                    } else {
                        // $data['author'][$i]['course_final_rating'] = 0;
                    }
                }
            } else {
                // $data['author'][$i]['course_final_rating'] = 0;
            }

            if ($bundling != null) {
                for ($z = 0; $z < count($bundling); $z++) {
                    $cek_bundling = $modelReview->where('bundling_id', $bundling[$z]['bundling_id'])->findAll();

                    $rating_bundling_raw = 0;
                    $rating_bundling_final = 0;

                    if ($cek_bundling != null) {
                        $reviewbundling = $modelReview->where('bundling_id', $bundling[$z]['bundling_id'])->findAll();

                        $rating_raw = 0;
                        $rating_final = 0;

                        for ($m = 0; $m < count($reviewbundling); $m++) {
                            $rating_raw += $reviewbundling[$m]['score'];
                            $rating_final = $rating_raw / count($reviewbundling);

                            // $data['author'][$i]['bundling'][$z]['rating_bundling'] = $rating_final;
                        }
                        $rating_bundling_raw += $rating_final;
                        $rating_bundling_final = $rating_bundling_raw / count($bundling);
                        // $data['author'][$i]['bundling_final_rating'] = $rating_bundling_final;
                    } else {
                        // $data['author'][$i]['bundling_final_rating'] = 0;
                    }
                }
            } else {
                // $data['author'][$i]['bundling_final_rating'] = 0;
            }

            if ($course != null || $bundling != null) {
                $rating_author_raw = $rating_bundling_final + $rating_course_final;
                $rating_author_final = $rating_author_raw / 2;
                $data['author'][$i]['author_final_rating'] = $rating_author_final;
            } else {
                $data['author'][$i]['author_final_rating'] = 0;
            }
        }
        return $this->respond($data);
    }
}
