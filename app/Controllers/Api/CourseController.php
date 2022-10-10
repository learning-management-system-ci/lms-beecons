<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseType;
use App\Models\CourseTag;
use App\Models\TypeTag;
use App\Models\Video;
use App\Models\VideoCategory;
use App\Models\Users;
use App\Models\UserVideo;
use App\Models\Review;
use App\Models\Jobs;
use App\Models\UserCourse;
use CodeIgniter\HTTP\RequestInterface;
use Firebase\JWT\JWT;
use getID3;

class CourseController extends ResourceController
{

    public function index()
    {
        $model = new Course();
        $modelCourseCategory = new CourseCategory();
        $modelCourseType = new CourseType();
        $modelCourseTag = new CourseTag();
        $modelTypeTag = new TypeTag();

        $data = $model->orderBy('course_id', 'DESC')->findAll();
        $tag = [];

        for ($i = 0; $i < count($data); $i++) {
            $category = $modelCourseCategory
                ->where('course_id', $data[$i]['course_id'])
                ->join('category', 'category.category_id = course_category.category_id')
                ->orderBy('course_category.course_category_id', 'DESC')
                ->findAll();
            $type = $modelCourseType
                ->where('course_id', $data[$i]['course_id'])
                ->join('type', 'type.type_id = course_type.type_id')
                ->orderBy('course_type.course_type_id', 'DESC')
                ->findAll();
            if ($type) {
                $data[$i]['type'] = $type;

                for ($k = 0; $k < count($type); $k++) {
                    $typeTag = $modelTypeTag
                        ->where('course_type.course_id', $data[$i]['course_id'])
                        ->where('type.type_id', $type[$k]['type_id'])
                        ->join('type', 'type.type_id = type_tag.type_id')
                        ->join('tag', 'tag.tag_id = type_tag.tag_id')
                        ->join('course_type', 'course_type.type_id = type.type_id')
                        ->orderBy('course_type.course_id', 'DESC')
                        ->select('tag.*')
                        ->findAll();

                    for ($o = 0; $o < count($typeTag); $o++) {
                        $data[$i]['tag'][$o] = $typeTag[$o];
                    }
                }
            } else {
                $data[$i]['type'] = null;
            }

            $data[$i]['category'] = $category;
        }

        if (count($data) > 0) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Tidak ada data');
        }
    }

    public function show($id = null)
    {
        // Jika tag kosong, berarti karena tidak ada data type_tag, atau tidak ada type_tag yang berelasi dengan course_type
        // Jika type null, berarti course tidak ada relasi dengan type

        // To get video duration
        include_once('getid3/getid3.php');
        $getID3 = new getID3;

        $model = new Course();
        $modelCourseCategory = new CourseCategory();
        $modelCourseType = new CourseType();
        $modelCourseTag = new CourseTag();
        $modelTypeTag = new TypeTag();
        $modelVideo = new Video();
        $modelVideoCategory = new VideoCategory();
        $modelReview = new Review();
        $modelUser = new Users();
        $modelJob = new Jobs();
        $modelUserCourse = new UserCourse();

        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');

        // Jika belum login
        if (!$header) {
            if ($model->find($id)) {
                $tag = [];
                $video = [];

                $data = $model->where('course_id', $id)->first();

                $category = $modelCourseCategory
                    ->where('course_id', $id)
                    ->join('category', 'category.category_id = course_category.category_id')
                    ->orderBy('course_category.course_category_id', 'DESC')
                    ->first();
                $type = $modelCourseType
                    ->where('course_id', $id)
                    ->join('type', 'type.type_id = course_type.type_id')
                    ->orderBy('course_type.course_type_id', 'DESC')
                    ->first();
                $videoCategory = $modelVideoCategory
                    ->where('course_id', $id)
                    ->orderBy('video_category.video_category_id', 'DESC')
                    ->findAll();

                if ($videoCategory[0]['title'] != '') {
                    $data['video_category'] = $videoCategory;
                }

                for ($l = 0; $l < count($videoCategory); $l++) {
                    $video = $modelVideo
                        ->where('video_category_id', $videoCategory[$l]['video_category_id'])
                        ->orderBy('order', 'DESC')
                        ->findAll();

                    if ($videoCategory[0]['title'] != '') {
                        $data['video_category'][$l]['video'] = $video;
                    } else {
                        $data['video'][$l] = $video;
                    }
                }

                if ($data['video']) {
                    for ($i = 0; $i < count($data['video']); $i++) {
                        $path = 'upload/course-video/';
                        $filename = $data['video'][$i]['video'];

                        $checkIfVideoIsLink = stristr($filename, 'http://') ?: stristr($filename, 'https://');

                        if (!$checkIfVideoIsLink) {
                            $file = $getID3->analyze($path . $filename);

                            $duration = ["duration" => $file['playtime_string']];
                            $data['video'][$i] += $duration;
                        } else {
                            $duration = ["duration" => null];
                            $data['video'][$i] += $duration;
                        }
                    }
                } elseif ($data['video_category']) {
                    for ($l = 0; $l < count($videoCategory); $l++) {
                        for ($i = 0; $i < count($data['video_category'][$l]); $i++) {
                            $path = 'upload/course-video/';
                            $filename = $data['video_category'][$l]['video'][$i]['video'];

                            $checkIfVideoIsLink = stristr($filename, 'http://') ?: stristr($filename, 'https://');

                            if (!$checkIfVideoIsLink) {
                                $file = $getID3->analyze($path . $filename);

                                $duration = ["duration" => $file['playtime_string']];
                                $data['video'][$i] += $duration;
                            } else {
                                $duration = ["duration" => null];
                                $data['video'][$i] += $duration;
                            }
                        }
                    }
                }

                if ($type) {
                    $typeTag = $modelTypeTag
                        ->where('course_type.course_id', $id)
                        ->where('type.type_id', $type['type_id'])
                        ->join('type', 'type.type_id = type_tag.type_id')
                        ->join('tag', 'tag.tag_id = type_tag.tag_id')
                        ->join('course_type', 'course_type.type_id = type.type_id')
                        ->orderBy('course_type.course_id', 'DESC')
                        ->select('tag.*')
                        ->findAll();

                    $data['type'] = $type;

                    for ($i = 0; $i < count($typeTag); $i++) {
                        $data['tag'][$i] = $typeTag[$i];
                    }
                } else {
                    $data['type'] = null;
                }

                $data['category'] = $category;

                $review = $modelReview->where('course_id', $id)->select('user_review_id, user_id, feedback, score')->orderBy('user_review_id', 'DESC')->findAll();

                for ($i = 0; $i < count($review); $i++) {
                    $user = $modelUser
                        ->where('id', $review[$i]['user_id'])
                        ->select('fullname, email, job_id')
                        ->first();
                    $job = $modelJob
                        ->where('job_id', $user['job_id'])
                        ->select('job_name')
                        ->first();
                    $review[$i] += $user;
                    $review[$i] += $job;
                }
                $data['review'] = $review;

                return $this->respond($data);
            } else {
                return $this->failNotFound('Tidak ada data');
            }
        } else {
            $userVideo = new UserVideo();
            $token = explode(' ', $header)[1];

            try {
                $decoded = JWT::decode($token, $key, ['HS256']);
                $user = new Users;
                $userCourse = $modelUserCourse->where('course_id', $id)->where('user_id', $decoded->uid)->first();

                if ($model->find($id)) {
                    $tag = [];
                    $video = [];

                    $data = $model->where('course_id', $id)->first();

                    if ($userCourse) {
                        $data['owned'] = 1;
                    } else {
                        $data['owned'] = 0;
                    }

                    $category = $modelCourseCategory
                        ->where('course_id', $id)
                        ->join('category', 'category.category_id = course_category.category_id')
                        ->orderBy('course_category.course_category_id', 'DESC')
                        ->first();
                    $type = $modelCourseType
                        ->where('course_id', $id)
                        ->join('type', 'type.type_id = course_type.type_id')
                        ->orderBy('course_type.course_type_id', 'DESC')
                        ->first();
                    $videoCategory = $modelVideoCategory
                        ->where('course_id', $id)
                        ->orderBy('video_category.video_category_id', 'DESC')
                        ->findAll();

                    if ($videoCategory[0]['title'] != '') {
                        $data['video_category'] = $videoCategory;
                    }

                    for ($l = 0; $l < count($videoCategory); $l++) {
                        $video = $modelVideo
                            ->where('video_category_id', $videoCategory[$l]['video_category_id'])
                            ->orderBy('order', 'DESC')
                            ->findAll();

                        if ($videoCategory[0]['title'] != '') {
                            $data['video_category'][$l]['video'] = $video;
                        } else {
                            $data['video'] = $video;
                        }

                        for ($p = 0; $p < count($video); $p++) {
                            $user_video = $userVideo
                                ->select('score')
                                ->where('user_id', $decoded->uid)
                                ->where('video_id', $video[$p]['video_id'])
                                ->findAll();
                            if ($user_video) {
                                $data['video'][$p]['score'] = $user_video[0]['score'];
                            } else {
                                $data['video'][$p]['score'] = null;
                            }
                        }
                    }

                    if ($data['video']) {
                        for ($i = 0; $i < count($data['video']); $i++) {
                            $path = 'upload/course-video/';
                            $filename = $data['video'][$i]['video'];

                            $checkIfVideoIsLink = stristr($filename, 'http://') ?: stristr($filename, 'https://');

                            if (!$checkIfVideoIsLink) {
                                $file = $getID3->analyze($path . $filename);

                                $duration = ["duration" => $file['playtime_string']];
                                $data['video'][$i] += $duration;
                            } else {
                                $duration = ["duration" => null];
                                $data['video'][$i] += $duration;
                            }
                        }
                    } elseif ($data['video_category']) {
                        for ($l = 0; $l < count($videoCategory); $l++) {
                            for ($i = 0; $i < count($data['video_category'][$l]); $i++) {
                                $path = 'upload/course-video/';
                                $filename = $data['video_category'][$l]['video'][$i]['video'];

                                $checkIfVideoIsLink = stristr($filename, 'http://') ?: stristr($filename, 'https://');

                                if (!$checkIfVideoIsLink) {
                                    $file = $getID3->analyze($path . $filename);

                                    $duration = ["duration" => $file['playtime_string']];
                                    $data['video'][$i] += $duration;
                                } else {
                                    $duration = ["duration" => null];
                                    $data['video'][$i] += $duration;
                                }
                            }
                        }
                    }

                    if ($type) {
                        $typeTag = $modelTypeTag
                            ->where('course_type.course_id', $id)
                            ->where('type.type_id', $type['type_id'])
                            ->join('type', 'type.type_id = type_tag.type_id')
                            ->join('tag', 'tag.tag_id = type_tag.tag_id')
                            ->join('course_type', 'course_type.type_id = type.type_id')
                            ->orderBy('course_type.course_id', 'DESC')
                            ->select('tag.*')
                            ->findAll();

                        $data['type'] = $type;

                        for ($i = 0; $i < count($typeTag); $i++) {
                            $data['tag'][$i] = $typeTag[$i];
                        }
                    } else {
                        $data['type'] = null;
                    }

                    $data['category'] = $category;

                    $review = $modelReview->where('course_id', $id)->select('user_review_id, user_id, feedback, score')->orderBy('user_review_id', 'DESC')->findAll();

                    for ($i = 0; $i < count($review); $i++) {
                        $user = $modelUser
                            ->where('id', $review[$i]['user_id'])
                            ->select('fullname, email, job_id')
                            ->first();
                        $job = $modelJob
                            ->where('job_id', $user['job_id'])
                            ->select('job_name')
                            ->first();
                        $review[$i] += $user;
                        $review[$i] += $job;
                    }
                    $data['review'] = $review;

                    return $this->respond($data);
                } else {
                    return $this->failNotFound('Tidak ada data');
                }
            } catch (\Throwable $th) {
                return $this->fail($th->getMessage());
            }
        }
    }

    public function filter($filter = null)
    {
        $model = new Course();
        $modelCourseCategory = new CourseCategory();
        $modelCourseType = new CourseType();
        $modelCourseTag = new CourseTag();
        $modelTypeTag = new TypeTag();

        $data = $model->orderBy('course_id', 'DESC')->where('service', $filter)->findAll();
        $tag = [];

        for ($i = 0; $i < count($data); $i++) {
            $category = $modelCourseCategory
                ->where('course_id', $data[$i]['course_id'])
                ->join('category', 'category.category_id = course_category.category_id')
                ->orderBy('course_category.course_category_id', 'DESC')
                ->findAll();
            $type = $modelCourseType
                ->where('course_id', $data[$i]['course_id'])
                ->join('type', 'type.type_id = course_type.type_id')
                ->orderBy('course_type.course_type_id', 'DESC')
                ->findAll();
            if ($type) {
                $data[$i]['type'] = $type;

                for ($k = 0; $k < count($type); $k++) {
                    $typeTag = $modelTypeTag
                        ->where('course_type.course_id', $data[$i]['course_id'])
                        ->where('type.type_id', $type[$k]['type_id'])
                        ->join('type', 'type.type_id = type_tag.type_id')
                        ->join('tag', 'tag.tag_id = type_tag.tag_id')
                        ->join('course_type', 'course_type.type_id = type.type_id')
                        ->orderBy('course_type.course_id', 'DESC')
                        ->select('tag.*')
                        ->findAll();

                    for ($o = 0; $o < count($typeTag); $o++) {
                        $data[$i]['tag'][$o] = $typeTag[$o];
                    }
                }
            } else {
                $data[$i]['type'] = null;
            }

            $data[$i]['category'] = $category;
        }

        if (count($data) > 0) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Tidak ada data');
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
            if ($data['role'] != 'admin') {
                return $this->fail('Tidak dapat di akses selain admin', 400);
            }
            // elseif ($data['role'] != 'member') {
            //    return $this->fail('Tidak dapat di akses selain member', 400);
            // }

            $modelCourse = new Course();
            $modelCourseCategory = new CourseCategory();

            $rules = [
                'title' => 'required|min_length[8]',
                'service' => 'required',
                'description' => 'required|min_length[8]',
                'key_takeaways' => 'max_length[255]',
                'suitable_for' => 'max_length[255]',
                'old_price' => 'required|numeric',
                'new_price' => 'required|numeric',
                'thumbnail' => 'required',
            ];

            $messages = [
                "title" => [
                    "required" => "{field} tidak boleh kosong",
                    'min_length' => '{field} minimal 8 karakter'
                ],
                "service" => [
                    "required" => "{field} tidak boleh kosong",
                ],
                "description" => [
                    "required" => "{field} tidak boleh kosong",
                    'min_length' => '{field} minimal 8 karakter'
                ],
                "key_takeaways" => [
                    'max_length' => '{field} maksimal 255 karakter',
                ],
                "suitable_for" => [
                    'max_length' => '{field} maksimal 255 karakter',
                ],
                "old_price" => [
                    "required" => "field} tidak boleh kosong",
                    "numeric" => "{field} harus berisi nomor",
                ],
                "new_price" => [
                    "required" => "field} tidak boleh kosong",
                    "numeric" => "{field} harus berisi nomor",
                ],
                "thumbnail" => [
                    "required" => "{field} tidak boleh kosong"
                ],
            ];

            if ($this->validate($rules, $messages)) {
                $dataCourse = [
                    'title' => $this->request->getVar('title'),
                    'service' => $this->request->getVar('service'),
                    'description' => $this->request->getVar('description'),
                    'key_takeaways' => $this->request->getVar('key_takeaways'),
                    'suitable_for' => $this->request->getVar('suitable_for'),
                    'old_price' => $this->request->getVar('old_price'),
                    'new_price' => $this->request->getVar('new_price'),
                    'thumbnail' => $this->request->getVar('thumbnail'),
                ];
                $modelCourse->insert($dataCourse);

                $dataCourseCategory = [
                    'course_id' => $modelCourse->insertID(),
                    'category_id' => $this->request->getVar('category_id')
                ];
                $modelCourseCategory->insert($dataCourseCategory);

                $response = [
                    'status'   => 201,
                    'success'    => 201,
                    'messages' => [
                        'success' => 'Course berhasil dibuat'
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
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);
            $user = new Users;

            // cek role user
            $data = $user->select('role')->where('id', $decoded->uid)->first();
            if ($data['role'] != 'admin') {
                return $this->fail('Tidak dapat di akses selain admin', 400);
            }
            // elseif ($data['role'] != 'member') {
            // return $this->fail('Tfidak dapat di akses selain member', 400);
            //}

            $modelCourse = new Course();
            $modelCourseCategory = new CourseCategory();

            $rules = [
                'title' => 'required|min_length[8]',
                'service' => 'required',
                'description' => 'required|min_length[8]',
                'key_takeaways' => 'max_length[255]',
                'suitable_for' => 'max_length[255]',
                'old_price' => 'required|numeric',
                'new_price' => 'required|numeric',
                'thumbnail' => 'required',
            ];

            $messages = [
                "title" => [
                    "required" => "{field}  tidak boleh kosong",
                    'min_length' => '{field} minimal 8 karakter'
                ],
                "service" => [
                    "required" => "{field} tidak boleh kosong",
                ],
                "description" => [
                    "required" => "{field}  tidak boleh kosong",
                    'min_length' => '{field} minimal 8 karakter'
                ],
                "key_takeaways" => [
                    'max_length' => '{field} maksimal 255 karakter',
                ],
                "suitable_for" => [
                    'max_length' => '{field} maksimal 255 karakter',
                ],
                "old_price" => [
                    "required" => "field} tidak boleh kosong",
                    "numeric" => "{field} harus berisi nomor",
                ],
                "new_price" => [
                    "required" => "field} tidak boleh kosong",
                    "numeric" => "{field} harus berisi nomor",
                ],
                "thumbnail" => [
                    "required" => "{field}  tidak boleh kosong"
                ],
            ];

            if ($modelCourse->find($id)) {
                if ($this->validate($rules, $messages)) {
                    $dataCourse = [
                        'title' => $this->request->getRawInput('title'),
                        'service' => $this->request->getRawInput('service'),
                        'description' => $this->request->getRawInput('description'),
                        'key_takeaways' => $this->request->getRawInput('key_takeaways'),
                        'suitable_for' => $this->request->getRawInput('suitable_for'),
                        'old_price' => $this->request->getRawInput('old_price'),
                        'new_price' => $this->request->getRawInput('new_price'),
                        'thumbnail' => $this->request->getRawInput('thumbnail')
                    ];
                    $modelCourse->update($id, $dataCourse['title']);

                    $dataCourseCategory = [
                        'course_id' => $id,
                        'category_id' => $this->request->getRawInput('category_id')['category_id']
                    ];
                    $courseCategoryID = $modelCourseCategory->where('course_id', $id)->find();
                    $modelCourseCategory->where('course_id', $id)->update($courseCategoryID[0]['course_category_id'], $dataCourseCategory);

                    $response = [
                        'status'   => 201,
                        'success'    => 201,
                        'messages' => [
                            'success' => 'Course berhasil di perbarui'
                        ]
                    ];
                } else {
                    $response = [
                        'status'   => 400,
                        'error'    => 400,
                        'messages' => $this->validator->getErrors(),
                    ];
                }
            } else {
                $response = [
                    'status'   => 400,
                    'error'    => 400,
                    'messages' => 'Data tidak ditemukan',
                ];
            }
            return $this->respondCreated($response);
        } catch (\Throwable $th) {
            // return $this->fail($th->getMessage());
            exit($th->getMessage());
        }
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

            // cek role user
            $data = $user->select('role')->where('id', $decoded->uid)->first();
            if ($data['role'] != 'admin') {
                return $this->fail('Tidak dapat di akses selain admin', 400);
            }
            // elseif ($data['role'] != 'member') {
            // return $this->fail('Tidak dapat di akses selain member', 400);
            //}

            $modelCourse = new Course();
            $modelCourseCategory = new CourseCategory();

            if ($modelCourse->find($id)) {
                $modelCourseCategory->where('course_id', $id)->delete();
                $modelCourse->delete($id);
                $response = [
                    'status'   => 200,
                    'success'    => 200,
                    'messages' => [
                        'success' => 'Course berhasil di hapus'
                    ]
                ];
                return $this->respondDeleted($response);
            } else {
                return $this->failNotFound('Data tidak di temukan');
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function latest($total = 4)
    {
        $model = new Course();

        $data = $model->limit($total)->orderBy('course_id', 'DESC')->find();
        return $this->respond($data);
    }

    public function find($key = null)
    {
        $model = new Course();
        $data = $model->orderBy('course_id', 'DESC')->like('title', $key)->find();

        if (count($data) > 0) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data tidak ditemukan');
        }
    }
}
