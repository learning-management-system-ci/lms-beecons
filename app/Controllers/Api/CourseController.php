<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseType;
use App\Models\CourseTag;
use App\Models\TypeTag;
use App\Models\Tag;
use App\Models\Resume;
use App\Models\Video;
use App\Models\VideoCategory;
use App\Models\Users;
use App\Models\UserVideo;
use App\Models\Review;
use App\Models\Jobs;
use App\Models\UserCourse;
use App\Models\Cart;
use App\Models\CourseBundling;
use CodeIgniter\HTTP\RequestInterface;
use Firebase\JWT\JWT;
use getID3;

class CourseController extends ResourceController
{
    function __construct()
    {
        include_once('getid3/getid3.php');
        $this->getID3 = new getID3;

        $this->key = getenv('TOKEN_SECRET');

        $this->path = site_url() . 'upload/course/thumbnail/';
        $this->pathVideo = site_url() . 'upload/course-video/';
        $this->pathVideoThumbnail = site_url() . 'upload/course-video/thumbnail/';

        $this->model = new Course();
        $this->modelCourseCategory = new CourseCategory();
        $this->modelCourseType = new CourseType();
        $this->modelTypeTag = new TypeTag();
        $this->modelVideo = new Video();
        $this->modelVideoCategory = new VideoCategory();
        $this->modelReview = new Review();
        $this->modelUser = new Users();
        $this->modelJob = new Jobs();
        $this->modelUserCourse = new UserCourse();
        $this->userVideo = new UserVideo();
        $this->modelResume = new Resume();
    }

    public function getTopic($id = null)
    {
        $model = new Course;

        $data = $model
            ->select('video.*')
            ->join('video_category', 'video_category.course_id = course.course_id')
            ->join('video', 'video.video_category_id = video_category.video_category_id')
            ->where('course.course_id', $id)
            ->findAll();

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['thumbnail'] = $this->path . $data[$i]['thumbnail'];
            $data[$i]['video'] = $this->pathVideo . $data[$i]['video'];
        }

        if (count($data) > 0) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Tidak ada data');
        }
    }

    public function index()
    {
        $model = new Course();
        $modelCourseCategory = new CourseCategory();
        $modelCourseType = new CourseType();
        $modelCourseTag = new CourseTag();
        $modelTypeTag = new TypeTag();
        $modelTag = new Tag();
        $modelUser = new Users();
        $modelVidCat = new VideoCategory();
        $modelVideo = new Video();

        $data = $model->orderBy('course_id', 'DESC')->where('service', 'course')->findAll();

        $tag = [];

        for ($i = 0; $i < count($data); $i++) {
            $author = $modelUser->where('id', $data[$i]['author_id'])->first();
            $data[$i]['author'] = $author['fullname'];
            unset($data[$i]['author_id']);

            $data[$i]['thumbnail'] = site_url() . 'upload/course/thumbnail/' . $data[$i]['thumbnail'];
            $category = $modelCourseCategory
                ->where('course_id', $data[$i]['course_id'])
                ->join('category', 'category.category_id = course_category.category_id')
                ->orderBy('course_category.course_category_id', 'DESC')
                ->first();
            $type = $modelCourseType
                ->where('course_id', $data[$i]['course_id'])
                ->join('type', 'type.type_id = course_type.type_id')
                ->orderBy('course_type.course_type_id', 'DESC')
                ->findAll();
            $tag = $modelCourseTag
                ->select('course_tag_id, course_tag.tag_id, name')
                ->where('course_id', $data[$i]['course_id'])
                ->join('tag', 'tag.tag_id = course_tag.tag_id')
                ->orderBy('course_tag.course_tag_id', 'DESC')
                ->findAll();
            $videoCat = $modelVidCat
                ->where('course_id', $data[$i]['course_id'])
                ->orderBy('video_category.video_category_id', 'DESC')
                ->findAll();
            if ($type) {

                $data[$i]['type'] = $type[0]["name"];

                for ($k = 0; $k < count($type); $k++) {
                    $typeTag = $modelTypeTag
                        ->where('course_type.course_id', $data[$i]['course_id'])
                        // ->where('course_tag.course_id', $data[$i]['course_id'])
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

                for ($x = 0; $x < count($videoCat); $x++) {
                    $video = $modelVideo
                        ->select('video_id, video, thumbnail')
                        ->where('video_category_id', $videoCat[$x]['video_category_id'])
                        ->orderBy('order', 'ASC')
                        ->findAll();

                    for ($z = 0; $z < count($video); $z++) {
                        $this->path = 'upload/course-video/';

                        $filename = $video[$z]['video'];
                        $video[$z]['thumbnail'] = $this->pathVideoThumbnail . $video[$z]['thumbnail'];

                        $checkIfVideoIsLink = stristr($filename, 'http://') ?: stristr($filename, 'https://');

                        if (!$checkIfVideoIsLink) {
                            $file = $this->getID3->analyze($this->path . $filename);

                            if (isset($file['error'][0])) {
                                $checkFileIsExist = false;
                            } else {
                                $checkFileIsExist = true;
                            }

                            if ($checkFileIsExist) {
                                if (isset($file['playtime_string'])) {
                                    $duration = ["duration" => $file['playtime_string']];
                                } else {
                                    $duration = ["duration" => '00:00:00'];
                                }

                                $data[$i]['video'][$z] = $duration;

                                $video[$z] += $duration;
                                $video[$z]['video'] = $this->pathVideo . $video[$z]['video'];
                            } else {
                                $duration = ["duration" => '00:00:00'];
                                $video[$z] += $duration;
                                $data[$i]['video'][$z] = $duration;
                            }
                        } else {
                            $duration = ["duration" => '00:00:00'];
                            $video[$z] += $duration;
                        }
                    }

                    $sum = strtotime('00:00:00');
                    $totalTime = 0;
                    $dataTime = $data[$i]['video'];

                    foreach ($dataTime as $element) {
                        $time = implode($element);
                        if (substr_count($time, ':') == 1) {
                            $waktu = '00:' . $time;
                        }
                        $strTime = date("H:i:s", strtotime($time));

                        $timeInSec = strtotime($strTime) - $sum;

                        $totalTime = $totalTime + $timeInSec;
                    }

                    $hours = intval($totalTime / 3600);

                    $totalTime = $totalTime - ($hours * 3600);

                    $minutes = intval($totalTime / 60);

                    $second = $totalTime - ($minutes * 60);

                    $result = ($hours . " Jam : " . $minutes . " Menit : " . $second . " Detik");

                    $data[$i]['total_video_duration'] = ["total" => $result];
                }
            } else {
                $data[$i]['type'] = null;
            }
            if ($tag) {
                $data[$i]['tag'] = $tag;
            } else {
                $data[$i]['tag'] = null;
            }

            $data[$i]['category'] = $category;
        }

        if (count($data) > 0) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Tidak ada data');
        }
    }

    public function getLatestCourseByAuthor($id = null)
    {
        $model = new Course();
        $modelCourseCategory = new CourseCategory();
        $modelCourseType = new CourseType();
        $modelCourseTag = new CourseTag();
        $modelTypeTag = new TypeTag();
        $modelUser = new Users();

        if (isset($_GET['limit'])) {
            $key = $_GET['limit'];
            $data = $model->limit($key)
                ->select('course.*,  users.fullname as author_name, category.name as category')
                ->join('users', 'users.id = course.author_id')
                ->join('course_category', 'course_category.course_category_id = course.course_id')
                ->join('category', 'category.category_id = course_category.category_id')
                ->where('users.id', $id)
                ->where('service', 'course')
                ->orderBy('course.course_id', 'DESC')->find();
        } else {
            $key = null;
            $data = $model->select('course.*, users.fullname as author_name, category.name as category')
                ->join('users', 'users.id = course.author_id')
                ->join('course_category', 'course_category.course_category_id = course.course_id')
                ->join('category', 'category.category_id = course_category.category_id')
                ->where('users.id', $id)
                ->where('service', 'course')
                ->orderBy('course.course_id', 'DESC')->find();
        }

        $tag = [];

        for ($i = 0; $i < count($data); $i++) {
            $author = $modelUser->where('id', $data[$i]['author_id'])->first();
            $data[$i]['author'] = $author['fullname'];
            unset($data[$i]['author_id']);

            $data[$i]['thumbnail'] = site_url() . 'upload/course/thumbnail/' . $data[$i]['thumbnail'];
            $category = $modelCourseCategory
                ->where('course_id', $data[$i]['course_id'])
                ->join('category', 'category.category_id = course_category.category_id')
                ->orderBy('course_category.course_category_id', 'DESC')
                ->first();
            $type = $modelCourseType
                ->where('course_id', $data[$i]['course_id'])
                ->join('type', 'type.type_id = course_type.type_id')
                ->orderBy('course_type.course_type_id', 'DESC')
                ->findAll();
            $tag = $modelCourseTag
                ->select('course_tag_id, course_tag.tag_id, name')
                ->where('course_id', $data[$i]['course_id'])
                ->join('tag', 'tag.tag_id = course_tag.tag_id')
                ->orderBy('course_tag.course_tag_id', 'DESC')
                ->findAll();
            if ($type) {
                $data[$i]['type'] = $type[0]["name"];

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

                    // for ($o = 0; $o < count($typeTag); $o++) {
                    //     $data[$i]['tag'][$o] = $typeTag[$o];
                    // }
                }
            } else {
                $data[$i]['type'] = null;
            }
            if ($tag) {
                $data[$i]['tag'] = $tag;
            } else {
                $data[$i]['tag'] = null;
            }

            $data[$i]['category'] = $category["name"];
        }

        if (count($data) > 0) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Tidak ada data');
        }
    }

    public function filterByCategory($filter = null, $id = null)
    {
        $model = new Course();
        $modelCourseCategory = new CourseCategory();
        $modelCourseType = new CourseType();
        $modelCourseTag = new CourseTag();
        $modelTypeTag = new TypeTag();
        $modelUser = new Users();

        if (isset($_GET['cat'])) {
            $key = $_GET['cat'];
            $data = $model->select('course.*, users.fullname as author_name, category.name as category')
                ->join('users', 'users.id = course.author_id')
                ->join('course_category', 'course_category.course_category_id = course.course_id')
                ->join('category', 'category.category_id = course_category.category_id')
                ->where('users.id', $id)
                ->where('service', $filter)
                ->like('category.name', $key)
                ->orderBy('course.course_id', 'DESC')->find();
        } else {
            $key = null;
            $data = $model->select('course.*, users.fullname as author_name, category.name as category')
                ->join('users', 'users.id = course.author_id')
                ->join('course_category', 'course_category.course_category_id = course.course_id')
                ->join('category', 'category.category_id = course_category.category_id')
                ->where('users.id', $id)
                ->where('service', $filter)
                ->orderBy('course.course_id', 'DESC')->find();
        }

        $tag = [];
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['thumbnail'] = site_url() . 'upload/course/thumbnail/' . $data[$i]['thumbnail'];
            $category = $modelCourseCategory
                ->where('course_id', $data[$i]['course_id'])
                ->join('category', 'category.category_id = course_category.category_id')
                ->orderBy('course_category.course_category_id', 'DESC')
                ->first();
            $type = $modelCourseType
                ->where('course_id', $data[$i]['course_id'])
                ->join('type', 'type.type_id = course_type.type_id')
                ->orderBy('course_type.course_type_id', 'DESC')
                ->findAll();
            $tag = $modelCourseTag
                ->select('course_tag_id, course_tag.tag_id, name')
                ->where('course_id', $data[$i]['course_id'])
                ->join('tag', 'tag.tag_id = course_tag.tag_id')
                ->orderBy('course_tag.course_tag_id', 'DESC')
                ->findAll();
            if ($type) {
                $data[$i]['type'] = $type[0]["name"];

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

                    // for ($o = 0; $o < count($typeTag); $o++) {
                    //     $data[$i]['tag'][$o] = $typeTag[$o];
                    // }
                }
            } else {
                $data[$i]['type'] = null;
            }
            if ($tag) {
                $data[$i]['tag'] = $tag;
            } else {
                $data[$i]['tag'] = null;
            }

            $data[$i]['category'] = $category["name"];
        }

        if (count($data) > 0) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Tidak ada data');
        }
    }

    public function getCourseById($id, $loggedIn = false)
    {
        if ($loggedIn) {
            $header = $this->request->getServer('HTTP_AUTHORIZATION');
            $token = explode(' ', $header)[1];
            $decoded = JWT::decode($token, $this->key, ['HS256']);
            $user = new Users;
            $userCourse = $this->modelUserCourse->where('course_id', $id)->where('user_id', $decoded->uid)->first();
        }

        // Jika video ditemukan
        if ($this->model->find($id)) {
            $video = [];
            $modelCourseTag = new CourseTag();

            $data = $this->model->where('course_id', $id)->first();
            $author = $this->modelUser->where('id', $data['author_id'])->first();
            unset($data['author_id']);
            $data['author'] = $author['fullname'];

            if ($loggedIn) {
                $checkUserReview = $this->modelReview->where('user_id', $decoded->uid)->where('course_id', $id)->first();
                if ($checkUserReview) {
                    $data['is_review'] = 'true';
                } else {
                    $data['is_review'] = 'false';
                }
            }

            $data['thumbnail'] = $this->path . $data['thumbnail'];

            $category = $this->modelCourseCategory
                ->where('course_id', $id)
                ->join('category', 'category.category_id = course_category.category_id')
                ->orderBy('course_category.course_category_id', 'DESC')
                ->first();
            $type = $this->modelCourseType
                ->where('course_id', $id)
                ->join('type', 'type.type_id = course_type.type_id')
                ->orderBy('course_type.course_type_id', 'DESC')
                ->first();
            $tag = $modelCourseTag
                ->select('course_tag_id, course_tag.tag_id, name')
                ->where('course_id', $id)
                ->join('tag', 'tag.tag_id = course_tag.tag_id')
                ->orderBy('course_tag.course_tag_id', 'DESC')
                ->findAll();
            $videoCategory = $this->modelVideoCategory
                ->where('course_id', $id)
                ->orderBy('video_category.video_category_id', 'DESC')
                ->findAll();

            if (isset($videoCategory[0]) && $videoCategory[0]['title'] != '') {
                $data['video_category'] = $videoCategory;
            }

            for ($l = 0; $l < count($videoCategory); $l++) {
                $video = $this->modelVideo
                    ->where('video_category_id', $videoCategory[$l]['video_category_id'])
                    ->orderBy('order', 'ASC')
                    ->findAll();
                if ($videoCategory[0]['title'] != '') {
                    $data['video_category'][$l]['video'] = $video;

                    if ($loggedIn)
                        for ($p = 0; $p < count($video); $p++) {
                            $user_video = $this->userVideo
                                ->select('score')
                                ->where('user_id', $decoded->uid)
                                ->where('video_id', $video[$p]['video_id'])
                                ->findAll();

                            $resume = $this->modelResume
                                ->where('user_id', $decoded->uid)
                                ->where('video_id', $data['video_category'][$l]['video'][$p]['video_id'])
                                ->first();

                            if ($resume) {
                                $data['video_category'][$l]['video'][$p]['resume'] = $resume;
                            } else {
                                $data['video_category'][$l]['video'][$p]['resume'] = null;
                            }

                            if ($user_video) {
                                $data['video_category'][$l]['video'][$p]['score'] = $user_video[0]['score'];
                            } else {
                                $data['video_category'][$l]['video'][$p]['score'] = null;
                            }
                        }
                } else {
                    $data['video'] = $video;

                    if ($loggedIn)
                        for ($p = 0; $p < count($video); $p++) {
                            $user_video = $this->userVideo
                                ->select('score')
                                ->where('user_id', $decoded->uid)
                                ->where('video_id', $video[$p]['video_id'])
                                ->findAll();

                            $resume = $this->modelResume
                                ->where('user_id', $decoded->uid)
                                ->where('video_id', $data['video'][$p]['video_id'])
                                ->first();

                            if ($resume) {
                                $data['video'][$p]['resume'] = $resume;
                            } else {
                                $data['video'][$p]['resume'] = null;
                            }

                            if ($user_video) {
                                $data['video'][$p]['score'] = $user_video[0]['score'];
                            } else {
                                $data['video'][$p]['score'] = null;
                            }
                        }
                }
            }

            if (isset($data['video'])) {
                for ($i = 0; $i < count($data['video']); $i++) {
                    $this->path = 'upload/course-video/';

                    $filename = $data['video'][$i]['video'];
                    $data['video'][$i]['thumbnail'] = $this->pathVideoThumbnail . $data['video'][$i]['thumbnail'];

                    $checkIfVideoIsLink = stristr($filename, 'http://') ?: stristr($filename, 'https://');

                    if (!$checkIfVideoIsLink) {
                        $file = $this->getID3->analyze($this->path . $filename);

                        if (isset($file['error'][0])) {
                            $checkFileIsExist = false;
                        } else {
                            $checkFileIsExist = true;
                        }

                        if ($checkFileIsExist) {
                            if (isset($file['playtime_string'])) {
                                $duration = ["duration" => $file['playtime_string']];
                            } else {
                                $duration = ["duration" => null];
                            }

                            $data['video'][$i] += $duration;
                            $data['video'][$i]['video'] = $this->pathVideo . $data['video'][$i]['video'];
                        } else {
                            $duration = ["duration" => null];
                            $data['video'][$i] += $duration;
                        }
                    } else {
                        $duration = ["duration" => null];
                        $data['video'][$i] += $duration;
                    }

                    if ($loggedIn) {
                        if (isset($userCourse)) {
                            $data['owned'] = true;
                        } else {
                            $data['owned'] = false;
                            if ($i != 0) {
                                $data['video'][$i]['video'] = null;
                            }
                        }
                    } else {
                        if ($i != 0) {
                            $data['video'][$i]['video'] = null;
                        }
                    }
                }
            } elseif (isset($data['video_category'])) {
                for ($l = 0; $l < count($videoCategory); $l++) {
                    if ($loggedIn) {
                        for ($i = 0; $i < count($data['video_category'][$l]['video']); $i++) {
                            $this->path = 'upload/course-video/';
                            $filename = $data['video_category'][$l]['video'][$i]['video'];

                            $checkIfVideoIsLink = stristr($filename, 'http://') ?: stristr($filename, 'https://');

                            if (!$checkIfVideoIsLink) {
                                $file = $this->getID3->analyze($this->path . $filename);
                                $checkFileIsExist = stristr($file['error'][0], '!file_exists') ? false : true;

                                if ($checkFileIsExist) {
                                    $duration = ["duration" => $file['playtime_string']];
                                    $data['video_category'][$l]['video'][$i] += $duration;
                                    $data['video_category'][$l]['video'][$i]['video'] = $this->pathVideo . $data['video_category'][$l]['video'][$i]['video'];
                                } else {
                                    $duration = ["duration" => null];
                                    $data['video_category'][$l]['video'][$i] += $duration;
                                }
                            } else {
                                $duration = ["duration" => null];
                                $data['video_category'][$l]['video'][$i] += $duration;
                            }

                            if (isset($data['owned']) && $i != 0) {
                                $data['video_category'][$l]['video'][$i]['video'] = null;
                            }
                        }
                    } else {
                        for ($i = 0; $i < count($data['video_category'][$l]['video']); $i++) {
                            $this->path = 'upload/course-video/';
                            $filename = $data['video_category'][$l]['video'][$i]['video'];

                            $checkIfVideoIsLink = stristr($filename, 'http://') ?: stristr($filename, 'https://');

                            if (!$checkIfVideoIsLink) {
                                $file = $this->getID3->analyze($this->path . $filename);
                                $checkFileIsExist = stristr($file['error'][0], '!file_exists') ? false : true;

                                if ($checkFileIsExist) {
                                    $duration = ["duration" => $file['playtime_string']];
                                    $data['video_category'][$l]['video'][$i] += $duration;
                                    $data['video_category'][$l]['video'][$i]['video'] = $this->pathVideo . $data['video_category'][$l]['video'][$i]['video'];
                                } else {
                                    $duration = ["duration" => null];
                                    $data['video_category'][$l]['video'][$i] += $duration;
                                }
                            } else {
                                $duration = ["duration" => null];
                                $data['video_category'][$l]['video'][$i] += $duration;
                            }

                            if ($i != 0) {
                                $data['video_category'][$l]['video'][$i]['video'] = null;
                            }
                        }
                    }
                }
            }

            if (isset($type)) {
                $typeTag = $this->modelTypeTag
                    ->where('course_type.course_id', $id)
                    ->where('type.type_id', $type['type_id'])
                    ->join('type', 'type.type_id = type_tag.type_id')
                    ->join('tag', 'tag.tag_id = type_tag.tag_id')
                    ->join('course_type', 'course_type.type_id = type.type_id')
                    ->orderBy('course_type.course_id', 'DESC')
                    ->select('tag.*')
                    ->findAll();

                $data['type'] = $type["name"];

                // for ($i = 0; $i < count($typeTag); $i++) {
                //     $data['tag'][$i] = $typeTag[$i];
                // }
            } else {
                $data['type'] = null;
            }
            if ($tag) {
                $data['tag'] = $tag;
            } else {
                $data['tag'] = null;
            }

            $data['category'] = $category['name'];

            $review = $this->modelReview->where('course_id', $id)->select('user_review_id, user_id, feedback, score')->orderBy('user_review_id', 'DESC')->findAll();

            for ($i = 0; $i < count($review); $i++) {
                $user = $this->modelUser
                    ->where('id', $review[$i]['user_id'])
                    ->select('fullname, email, job_id')
                    ->first();
                $job = $this->modelJob
                    ->where('job_id', $user['job_id'])
                    ->select('job_name')
                    ->first();
                $review[$i] += $user;

                if ($user['job_id'] != null) {
                    $review[$i] += $job;
                }
            }
            $data['review'] = $review;

            return $this->respond($data);
        } else {
            return $this->failNotFound('Tidak ada data');
        }
    }

    public function show($id = null)
    {
        $header = $this->request->getServer('HTTP_AUTHORIZATION');

        // Jika belum login
        if (!$header) {
            return $this->getCourseById($id);
        } else {
            try {
                return $this->getCourseById($id, true);
            } catch (\Throwable $th) {
                return $this->fail($th->getMessage());
            }
        }
    }

    public function trainingByAuthor($filter = null, $author_id = null)
    {
        $model = new Course();
        $modelCourseCategory = new CourseCategory();
        $modelCourseType = new CourseType();
        $modelCourseTag = new CourseTag();
        $modelTypeTag = new TypeTag();
        $modelUser = new Users();

        $data = $model->select('course.*, users.fullname as author_name')
            ->orderBy('course_id', 'DESC')
            ->where('service', $filter)
            ->where('author_id', $author_id)
            ->join('users', 'users.id = course.author_id')
            ->findAll();

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
            $tag = $modelCourseTag
                ->select('course_tag_id, course_tag.tag_id, name')
                ->where('course_id', $data[$i]['course_id'])
                ->join('tag', 'tag.tag_id = course_tag.tag_id')
                ->orderBy('course_tag.course_tag_id', 'DESC')
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
            if ($tag) {
                $data[$i]['tag'] = $tag;
            } else {
                $data[$i]['tag'] = null;
            }
            $data[$i]['category'] = $category;
        }

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['thumbnail'] = $this->path . $data[$i]['thumbnail'];
        }

        if (count($data) > 0) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Tidak ada data');
        }
    }

    public function filter($filter = null)
    {
        $model = new Course();
        $modelCourseCategory = new CourseCategory();
        $modelCourseType = new CourseType();
        $modelCourseTag = new CourseTag();
        $modelTypeTag = new TypeTag();
        $modelUser = new Users();

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
            $data[$i]['thumbnail'] = site_url() . 'upload/course/thumbnail/' . $data[$i]['thumbnail'];
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

    public function author($id = null)
    {
        $model = new Course();
        $modelCourseCategory = new CourseCategory();
        $modelCourseType = new CourseType();
        $modelCourseTag = new CourseTag();
        $modelTypeTag = new TypeTag();
        $modelUser = new Users();

        $data = $model->orderBy('course_id', 'DESC')->where('author_id', $id)->where('service', 'course')->find();

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['thumbnail'] = $this->path . $data[$i]['thumbnail'];

            $user = $modelUser->select('fullname')->where('id', $id)->first();
            $data[$i]['author_name'] = $user['fullname'];

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
            $tag = $modelCourseTag
                ->select('course_tag_id, course_tag.tag_id, name')
                ->where('course_id', $data[$i]['course_id'])
                ->join('tag', 'tag.tag_id = course_tag.tag_id')
                ->orderBy('course_tag.course_tag_id', 'DESC')
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
            if ($tag) {
                $data[$i]['tag'] = $tag;
            } else {
                $data[$i]['tag'] = null;
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
            if ($data['role'] == 'member' || $data['role'] == 'mentor') {
                return $this->fail('Tidak dapat di akses selain admin, partner & author', 400);
            }

            $modelCourse = new Course();
            $modelCourseCategory = new CourseCategory();
            $modelCourseType = new CourseType();
            $modelCourseTag = new CourseTag();

            $rules = [
                'title' => 'required|min_length[8]',
                'service' => 'required',
                'description' => 'required|min_length[8]',
                'key_takeaways' => 'max_length[255]',
                'suitable_for' => 'max_length[255]',
                'old_price' => 'required|numeric',
                'new_price' => 'permit_empty|numeric',
                'thumbnail' => 'uploaded[thumbnail]'
                    . '|is_image[thumbnail]'
                    . '|mime_in[thumbnail,image/jpg,image/jpeg,image/png,image/webp]'
                    . '|max_size[thumbnail,4000]',
                'category_id' => 'required|numeric',
                'type_id' => 'required|numeric',
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
                "category_id" => [
                    "required" => "{field} tidak boleh kosong",
                    "numeric" => "{field} harus berisi nomor",
                ],
                "type_id" => [
                    "required" => "{field} tidak boleh kosong",
                    "numeric" => "{field} harus berisi nomor",
                ],
            ];

            if ($this->validate($rules, $messages)) {
                $dataThumbnail = $this->request->getFile('thumbnail');
                $fileName = $dataThumbnail->getRandomName();
                $dataCourse = [
                    'title' => $this->request->getVar('title'),
                    'service' => $this->request->getVar('service'),
                    'description' => $this->request->getVar('description'),
                    'key_takeaways' => $this->request->getVar('key_takeaways'),
                    'suitable_for' => $this->request->getVar('suitable_for'),
                    'old_price' => $this->request->getVar('old_price'),
                    'new_price' => $this->request->getVar('new_price'),
                    'author_id' => $this->request->getVar('author_id'),
                    'thumbnail' => $fileName,
                    'author_id' => $decoded->uid,
                ];
                $dataThumbnail->move('upload/course/thumbnail/', $fileName);
                $modelCourse->insert($dataCourse);

                $dataCourseCategory = [
                    'course_id' => $modelCourse->insertID(),
                    'category_id' => $this->request->getVar('category_id')
                ];
                $dataCourseType = [
                    'course_id' => $modelCourse->insertID(),
                    'type_id' => $this->request->getVar('type_id')
                ];

                if ($this->request->getVar('tag') !== null) {
                    $dataCourseTag = [];
                    $tag = json_decode($this->request->getVar('tag'));
                    for ($i = 0; $i < count($tag); $i++) {
                        $dataCourseTag[$i] = [
                            'course_id' => $modelCourse->insertID(),
                            'tag_id' => $tag[$i]
                        ];
                    }
                    $modelCourseTag->insertBatch($dataCourseTag);
                }

                $modelCourseCategory->insert($dataCourseCategory);
                $modelCourseType->insert($dataCourseType);

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
            if ($data['role'] == 'member' || $data['role'] == 'mentor') {
                return $this->fail('Tidak dapat di akses selain admin, partner & author', 400);
            }

            $modelCourse = new Course();
            $modelCourseCategory = new CourseCategory();
            $modelCourseType = new CourseType();
            $modelCourseTag = new CourseTag();

            $rules_a = [
                'title' => 'required',
                'description' => 'required|min_length[8]',
                'key_takeaways' => 'max_length[255]',
                'suitable_for' => 'max_length[255]',
                'old_price' => 'required|numeric',
                'new_price' => 'required|numeric',
                'category_id' => 'numeric',
                'type_id' => 'numeric',
            ];

            $rules_b = [
                'thumbnail' => 'uploaded[thumbnail]'
                    . '|is_image[thumbnail]'
                    . '|mime_in[thumbnail,image/jpg,image/jpeg,image/png,image/webp]'
                    . '|max_size[thumbnail,4000]'
            ];

            $messages_a = [
                "title" => [
                    "required" => "{field}  tidak boleh kosong",
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
                    "required" => "{field} tidak boleh kosong",
                    "numeric" => "{field} harus berisi nomor",
                ],
                "new_price" => [
                    "required" => "{field} tidak boleh kosong",
                    "numeric" => "{field} harus berisi nomor",
                ],
                "category_id" => [
                    "numeric" => "{field} harus berisi nomor",
                ],
                "type_id" => [
                    "numeric" => "{field} harus berisi nomor",
                ],
            ];

            $messages_b = [
                "thumbnail" => [
                    'uploaded' => '{field} tidak boleh kosong',
                    'mime_in' => 'File Extention Harus Berupa png, jpg, atau jpeg',
                    'max_size' => 'Ukuran File Maksimal 4 MB'
                ],
            ];

            $findCourse = $this->model->where('course_id', $id)->first();
            if ($findCourse) {
                if ($this->validate($rules_a, $messages_a)) {
                    if ($this->validate($rules_b, $messages_b)) {
                        $oldThumbnail = $findCourse['thumbnail'];
                        $dataThumbnail = $this->request->getFile('thumbnail');

                        if ($dataThumbnail->isValid() && !$dataThumbnail->hasMoved()) {
                            if (file_exists("upload/course/thumbnail/" . $oldThumbnail)) {
                                unlink("upload/course/thumbnail/" . $oldThumbnail);
                            }
                            $fileName = $dataThumbnail->getRandomName();
                            $dataThumbnail->move('upload/course/thumbnail/', $fileName);
                        } else {
                            $fileName = $oldThumbnail['thumbnail'];
                        }

                        $data = [
                            'title' => $this->request->getVar('title'),
                            'service' => $this->request->getVar('service'),
                            'description' => $this->request->getVar('description'),
                            'key_takeaways' => $this->request->getVar('key_takeaways'),
                            'suitable_for' => $this->request->getVar('suitable_for'),
                            'old_price' => $this->request->getVar('old_price'),
                            'new_price' => $this->request->getVar('new_price'),
                            'author_id' => $this->request->getVar('author_id'),
                            'thumbnail' => $fileName,
                            'author_id' => $decoded->uid,
                        ];

                        $modelCourse->update($id, $data);

                        if ($this->request->getVar('category_id') !== null) {
                            $dataCourseCategory = [
                                'category_id' => $this->request->getVar('category_id')
                            ];
                            $modelCourseCategory->where('course_id', $id)->set($dataCourseCategory)->update();
                        };

                        if ($this->request->getVar('type_id') !== null) {
                            $dataCourseType = [
                                'type_id' => $this->request->getVar('type_id')
                            ];
                            $modelCourseType->where('course_id', $id)->set($dataCourseType)->update();
                        };

                        if ($this->request->getVar('tag') !== null) {
                            $dataCourseTag = [];
                            $tag = json_decode($this->request->getVar('tag'));
                            for ($i = 0; $i < count($tag); $i++) {
                                $dataCourseTag[$i] = [
                                    'course_id' => $id,
                                    'tag_id' => $tag[$i]
                                ];
                            }
                            $modelCourseTag->where('course_id', $id)->delete();
                            $modelCourseTag->insertBatch($dataCourseTag);
                        }

                        $response = [
                            'status'   => 201,
                            'success'    => 201,
                            'messages' => [
                                'success' => 'Data Course berhasil diupdate'
                            ]
                        ];
                    } else {
                        // $response = [
                        //     'status'   => 400,
                        //     'error'    => 400,
                        //     'messages' => $this->validator->getErrors(),
                        // ];
                        $dataCourse = [
                            'title' => $this->request->getVar('title'),
                            'service' => $this->request->getVar('service'),
                            'description' => $this->request->getVar('description'),
                            'key_takeaways' => $this->request->getVar('key_takeaways'),
                            'suitable_for' => $this->request->getVar('suitable_for'),
                            'old_price' => $this->request->getVar('old_price'),
                            'new_price' => $this->request->getVar('new_price'),
                            'author_id' => $decoded->uid,
                        ];

                        $modelCourse->update($id, $dataCourse);

                        if ($this->request->getVar('category_id') !== null) {
                            $dataCourseCategory = [
                                'category_id' => $this->request->getVar('category_id')
                            ];
                            $modelCourseCategory->where('course_id', $id)->set($dataCourseCategory)->update();
                        };

                        if ($this->request->getVar('type_id') !== null) {
                            $dataCourseType = [
                                'type_id' => $this->request->getVar('type_id')
                            ];
                            $modelCourseType->where('course_id', $id)->set($dataCourseType)->update();
                        };

                        if ($this->request->getVar('tag') !== null) {
                            $dataCourseTag = [];
                            $tag = json_decode($this->request->getVar('tag'));
                            for ($i = 0; $i < count($tag); $i++) {
                                $dataCourseTag[$i] = [
                                    'course_id' => $id,
                                    'tag_id' => $tag[$i]
                                ];
                            }
                            $modelCourseTag->where('course_id', $id)->delete();
                            $modelCourseTag->insertBatch($dataCourseTag);
                        }

                        $response = [
                            'status'   => 201,
                            'success'    => 201,
                            'messages' => [
                                'success' => 'Data Course berhasil diupasdasddate'
                            ]
                        ];
                    }
                    // Kalau disini ada update, maka update 2 kali
                } else {
                    $response = [
                        'status'   => 400,
                        'error'    => 400,
                        'messages' => $this->validator->getErrors(),
                    ];
                }
            }

            return $this->respondCreated($response);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data Course tidak ditemukan');
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
            if ($data['role'] == 'member' || $data['role'] == 'mentor') {
                return $this->fail('Tidak dapat di akses selain admin, partner & author', 400);
            }

            $modelCourse = new Course();
            $modelCourseCategory = new CourseCategory();
            $modelCart = new Cart;
            $modelUserCourse = new UserCourse;
            $modelCourseTag = new CourseTag;
            $modelUserReview = new Review;
            $modelCourseType = new CourseType;
            $modelCourseBundling = new CourseBundling;
            $modelVideoCategory = new VideoCategory;


            if ($modelCourse->find($id)) {
                $modelCourseCategory->where('course_id', $id)->delete();
                $modelUserCourse->where('course_id', $id)->delete();
                $modelCourseTag->where('course_id', $id)->delete();
                $modelUserReview->where('course_id', $id)->delete();
                $modelCourseType->where('course_id', $id)->delete();
                $modelCourseBundling->where('course_id', $id)->delete();
                $modelVideoCategory->where('course_id', $id)->delete();
                $modelCart->where('course_id', $id)->delete();
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
        $modelCourseCategory = new CourseCategory();
        $modelCourseType = new CourseType();
        $modelCourseTag = new CourseTag();
        $modelTypeTag = new TypeTag();
        $modelTag = new Tag();
        $modelUser = new Users();
        $modelVidCat = new VideoCategory();
        $modelVideo = new Video();

        $data = $model->limit($total)->orderBy('course_id', 'DESC')->where('service', 'course')->find();

        $tag = [];

        for ($i = 0; $i < count($data); $i++) {
            $author = $modelUser->where('id', $data[$i]['author_id'])->first();
            $data[$i]['author'] = $author['fullname'];
            unset($data[$i]['author_id']);

            $data[$i]['thumbnail'] = site_url() . 'upload/course/thumbnail/' . $data[$i]['thumbnail'];
            $category = $modelCourseCategory
                ->where('course_id', $data[$i]['course_id'])
                ->join('category', 'category.category_id = course_category.category_id')
                ->orderBy('course_category.course_category_id', 'DESC')
                ->first();
            $type = $modelCourseType
                ->where('course_id', $data[$i]['course_id'])
                ->join('type', 'type.type_id = course_type.type_id')
                ->orderBy('course_type.course_type_id', 'DESC')
                ->findAll();
            $tag = $modelCourseTag
                ->select('course_tag_id, course_tag.tag_id, name')
                ->where('course_id', $data[$i]['course_id'])
                ->join('tag', 'tag.tag_id = course_tag.tag_id')
                ->orderBy('course_tag.course_tag_id', 'DESC')
                ->findAll();
            $videoCat = $modelVidCat
                ->where('course_id', $data[$i]['course_id'])
                ->orderBy('video_category.video_category_id', 'DESC')
                ->findAll();
            if ($type) {

                $data[$i]['type'] = $type[0]["name"];

                for ($k = 0; $k < count($type); $k++) {
                    $typeTag = $modelTypeTag
                        ->where('course_type.course_id', $data[$i]['course_id'])
                        // ->where('course_tag.course_id', $data[$i]['course_id'])
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

                for ($x = 0; $x < count($videoCat); $x++) {
                    $video = $modelVideo
                        ->select('video_id, video, thumbnail')
                        ->where('video_category_id', $videoCat[$x]['video_category_id'])
                        ->orderBy('order', 'ASC')
                        ->findAll();

                    for ($z = 0; $z < count($video); $z++) {
                        $this->path = 'upload/course-video/';

                        $filename = $video[$z]['video'];
                        $video[$z]['thumbnail'] = $this->pathVideoThumbnail . $video[$z]['thumbnail'];

                        $checkIfVideoIsLink = stristr($filename, 'http://') ?: stristr($filename, 'https://');

                        if (!$checkIfVideoIsLink) {
                            $file = $this->getID3->analyze($this->path . $filename);

                            if (isset($file['error'][0])) {
                                $checkFileIsExist = false;
                            } else {
                                $checkFileIsExist = true;
                            }

                            if ($checkFileIsExist) {
                                if (isset($file['playtime_string'])) {
                                    $duration = ["duration" => $file['playtime_string']];
                                } else {
                                    $duration = ["duration" => '00:00:00'];
                                }

                                $data[$i]['video'][$z] = $duration;

                                $video[$z] += $duration;
                                $video[$z]['video'] = $this->pathVideo . $video[$z]['video'];
                            } else {
                                $duration = ["duration" => '00:00:00'];
                                $video[$z] += $duration;
                                $data[$i]['video'][$z] = $duration;
                            }
                        } else {
                            $duration = ["duration" => '00:00:00'];
                            $video[$z] += $duration;
                        }
                    }

                    $sum = strtotime('00:00:00');
                    $totalTime = 0;
                    $dataTime = $data[$i]['video'];

                    foreach ($dataTime as $element) {
                        $time = implode($element);
                        if (substr_count($time, ':') == 1) {
                            $waktu = '00:' . $time;
                        }
                        $strTime = date("H:i:s", strtotime($time));

                        $timeInSec = strtotime($strTime) - $sum;

                        $totalTime = $totalTime + $timeInSec;
                    }

                    $hours = intval($totalTime / 3600);

                    $totalTime = $totalTime - ($hours * 3600);

                    $minutes = intval($totalTime / 60);

                    $second = $totalTime - ($minutes * 60);

                    $result = ($hours . " Jam : " . $minutes . " Menit : " . $second . " Detik");

                    $data[$i]['total_video_duration'] = ["total" => $result];
                }
            } else {
                $data[$i]['type'] = null;
            }
            if ($tag) {
                $data[$i]['tag'] = $tag;
            } else {
                $data[$i]['tag'] = null;
            }

            $data[$i]['category'] = $category;
        }

        if (count($data) > 0) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Tidak ada data');
        }
    }

    public function find($key = null)
    {
        $model = new Course();
        $modelCourseCategory = new CourseCategory();
        $modelCourseType = new CourseType();
        $modelCourseTag = new CourseTag();
        $modelTypeTag = new TypeTag();
        $modelUser = new Users();

        $data = $model->orderBy('course_id', 'DESC')->like('title', $key)->find();


        $tag = [];

        for ($i = 0; $i < count($data); $i++) {
            $author = $modelUser->where('id', $data[$i]['author_id'])->first();
            $data[$i]['author'] = $author['fullname'];
            unset($data[$i]['author_id']);

            $data[$i]['thumbnail'] = $this->path . $data[$i]['thumbnail'];
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
            $tag = $modelCourseTag
                ->select('course_tag_id, course_tag.tag_id, name')
                ->where('course_id', $data[$i]['course_id'])
                ->join('tag', 'tag.tag_id = course_tag.tag_id')
                ->orderBy('course_tag.course_tag_id', 'DESC')
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

                    // for ($o = 0; $o < count($typeTag); $o++) {
                    //     $data[$i]['tag'][$o] = $typeTag[$o];
                    // }
                }
            } else {
                $data[$i]['type'] = null;
            }
            if ($tag) {
                $data[$i]['tag'] = $tag;
            } else {
                $data[$i]['tag'] = null;
            }

            $data[$i]['category'] = $category;
        }

        if (count($data) > 0) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data tidak ditemukan');
        }
    }

    public function filterByTitle($filter = null, $id = null)
    {
        $model = new Course();
        $modelCourseCategory = new CourseCategory();
        $modelCourseType = new CourseType();
        $modelCourseTag = new CourseTag();
        $modelTypeTag = new TypeTag();
        $modelUser = new Users();

        if (isset($_GET['title'])) {
            $key = $_GET['title'];
            $data = $model->select('course.*, users.fullname as author_name, category.name as category')
                ->join('users', 'users.id = course.author_id')
                ->join('course_category', 'course_category.course_category_id = course.course_id')
                ->join('category', 'category.category_id = course_category.category_id')
                ->where('users.id', $id)
                ->where('service', $filter)
                ->like('course.title', $key)
                ->orderBy('course.course_id', 'DESC')->find();
        } else {
            $key = null;
            $data = $model->select('course.*, users.fullname as author_name, category.name as category')
                ->join('users', 'users.id = course.author_id')
                ->join('course_category', 'course_category.course_category_id = course.course_id')
                ->join('category', 'category.category_id = course_category.category_id')
                ->where('users.id', $id)
                ->where('service', $filter)
                ->orderBy('course.course_id', 'DESC')->find();
        }

        $tag = [];

        for ($i = 0; $i < count($data); $i++) {
            $author = $modelUser->where('id', $data[$i]['author_id'])->first();
            $data[$i]['author'] = $author['fullname'];
            unset($data[$i]['author_id']);

            $data[$i]['thumbnail'] = $this->path . $data[$i]['thumbnail'];
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
            $tag = $modelCourseTag
                ->select('course_tag_id, course_tag.tag_id, name')
                ->where('course_id', $data[$i]['course_id'])
                ->join('tag', 'tag.tag_id = course_tag.tag_id')
                ->orderBy('course_tag.course_tag_id', 'DESC')
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

                    // for ($o = 0; $o < count($typeTag); $o++) {
                    //     $data[$i]['tag'][$o] = $typeTag[$o];
                    // }
                }
            } else {
                $data[$i]['type'] = null;
            }
            if ($tag) {
                $data[$i]['tag'] = $tag;
            } else {
                $data[$i]['tag'] = null;
            }

            $data[$i]['category'] = $category;
        }

        if (count($data) > 0) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Tidak ada data');
        }
    }
}
