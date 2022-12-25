<?php

namespace App\Controllers\Api;

use App\Controllers\Api\UserController as ApiUserController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Resume;
use App\Models\UserCourse;
use App\Models\Course;
use App\Models\Video;
use App\Models\UserVideo;
use App\Models\VideoCategory;
use App\Models\Users;
use App\Controllers\UserController;
use Firebase\JWT\JWT;

class ResumeController extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->resume = new Resume();
        $this->usercontroller = new ApiUserController();
    }

    public function index(){
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

            $path = site_url() . 'upload/course/resume/';
            
            $dataresume = $this->resume->findAll();

            for ($i = 0; $i < count($dataresume); $i++) {
                if ($dataresume[$i]['task'] != null){
                    $dataresume[$i]['task'] = $path . $dataresume[$i]['task'];
                };
            }

        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->respond($dataresume);
    }
    
    public function show($id = null){
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);

            $path = site_url() . 'upload/course/resume/';

            $data = $this->resume->where('resume_id', $id)->first();

            if ($data['task'] != null){
                $data['task'] = $path . $data['task'];
            };
            
            if($data){
                return $this->respond($data);
            }else{
                return $this->failNotFound('Data Resume tidak ditemukan');
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Resume tidak ditemukan');
    }

    public function showadmin($id = null){
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

            $data = $this->resume->where('resume_id', $id)->first();
            
            if($data){
                return $this->respond($data);
            }else{
                return $this->failNotFound('Data Resume tidak ditemukan');
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Resume tidak ditemukan');
    }

    public function create()
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);

            $rules_a = [
                'video_id' => 'required',
                'resume' => 'required|min_length[50]|max_length[3000]'
            ];

            $rules_b = [
                "task" => "uploaded[task]|max_size[task,262144]",
            ];

            $messages_a = [
                "video_id" => [
                    "required" => "{field} tidak boleh kosong",
                ],
                "resume" => [
                    "required" => "{field} tidak boleh kosong",
                    "min_length" => "{field} minimal 50 karakter",
                    "max_length" => "{field} maksimal 3000 karakter",
                ],
            ];

            $messages_b = [
                "task" => [
					'uploaded' => '{field} tidak boleh kosong',
					'max_size' => 'Ukuran {field} Maksimal 256 MB'
				],
            ];

            if($this->validate($rules_a, $messages_a) == TRUE && $this->validate($rules_b, $messages_b) == FALSE) {
                
                $dataresume = [
                    'video_id' => $this->request->getVar('video_id'),
                    'user_id' => $decoded->uid,
                    'resume' => $this->request->getVar('resume'),
                ];
                $this->resume->insert($dataresume);

                $response = [
                    'status'   => 201,
                    'success'    => 201,
                    'messages' => [
                        'success' => 'Resume berhasil dibuat'
                    ]
                ];
            } elseif($this->validate($rules_a, $messages_a) == TRUE && $this->validate($rules_b, $messages_b) == TRUE) {
                $datatask = $this->request->getFile('task');
                $fileName = $datatask->getRandomName();
                $dataresume = [
                    'video_id' => $this->request->getVar('video_id'),
                    'user_id' => $decoded->uid,
                    'resume' => $this->request->getVar('resume'),
                    'task' => $fileName,
                ];
                $datatask->move('upload/course/resume/', $fileName);
                $this->resume->insert($dataresume);
    
                $response = [
                    'status'   => 201,
                    'success'    => 201,
                    'messages' => [
                        'success' => 'Resume berhasil dibuat'
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

            $input = $this->request->getRawInput();

            $rules = [
                'video_id' => 'required',
                'resume' => 'required|max_length[3000]'
            ];

            $messages = [
                "video_id" => [
                    "required" => "{field} tidak boleh kosong",
                ],
                "resume" => [
                    "required" => "{field} tidak boleh kosong",
                    "max_length" => "{field} maksimal 3000 karakter",
                ],
            ];

            $data = [
                "video_id" => $input["video_id"],
                "user_id" => $decoded->uid,
                "resume" => $input["resume"],
            ];

            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Resume berhasil diperbarui'
                ]
            ];

            $cek = $this->resume->where('resume_id', $id)->findAll();

            if(!$cek){
                return $this->failNotFound('Data Resume tidak ditemukan');
            }

            if (!$this->validate($rules, $messages)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            if ($this->resume->update($id, $data)){
                return $this->respond($response);
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
		return $this->failNotFound('Data Resume tidak ditemukan');
	}

    public function getBundlingSertifikat($course_id = null){
        $modelUserCourse = new UserCourse();
        $modelVideo = new Video();
        $modelUserVideo = new UserVideo();
        $modelCourse = new Course;
        $modelVideoCategory = new VideoCategory;

        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);

            $course = $modelUserCourse
                ->where('user_course.course_id', $course_id)
                ->where('user_course.user_id', $decoded->uid)
                ->join('users', 'user_course.user_id=users.id')
                ->join('course', 'user_course.course_id=course.course_id')
                ->join('video_category', 'user_course.course_id=video_category.course_id')
                ->select('users.id, users.fullname, course.title, user_course.created_at, video_category.video_category_id')
                ->findAll();

            $data['course'] = $course;

            for ($l = 0; $l < count($course); $l++) {
                $video = $modelVideo
                    ->where('video_category_id', $course[$l]['video_category_id'])
                    ->select('video.*')
                    ->findAll();
    
                $data['course'][$l]['video'] = $video;

                for ($i = 0; $i < count($video); $i++) {
                    $uservideo = $modelUserVideo
                        ->where('video_id', $video[$i]['video_id'])
                        ->where('user_id', $course[$l]['id'])
                        ->select('user_video.score')
                        ->findAll();
                    
                    if ($uservideo == null) {
                        $uservideo = null;
                    }else {
                        $uservideo = $uservideo;
                    }
                    
                    $data['course'][$l]['video'][$i]['hasil_score'] = $uservideo;
                }

                for ($x = 0; $x < count($video); $x++) {
                    $resume = $this->resume
                        ->where('video_id', $video[$x]['video_id'])
                        ->where('user_id', $course[$l]['id'])
                        ->select('resume.resume')
                        ->findAll();
        
                    if ($resume == null) {
                        $resume = null;
                    }else {
                        $resume = $resume;
                    }

                    $data['course'][$l]['video'][$x]['resume_video'] = $resume;
                }
            }

            $userCourse = $modelUserCourse->where('user_id', $decoded->uid)->where('user_course.course_id', $course_id)->findAll();

            if($userCourse == null){
                return $this->failNotFound('Anda Tidak Memiliki Course');
            }
            $course = $userCourse;
            $score_raw = 0;
            $score_final = 0;
            for ($i = 0; $i < count($userCourse); $i++) {
                $course_ = $modelCourse->where('course_id', $userCourse[$i]['course_id'])->first();
                $course[$i] = $course_;

                $videoCat_ = $modelVideoCategory->where('course_id', $userCourse[$i]['course_id'])->first();
                $video_ = $modelVideo->where('video_category_id', $videoCat_['video_category_id'])->findAll();

                $userVideo = 0;
                for($l = 0; $l < count($video_); $l++){
                    $userVideo_ = $modelUserVideo->where('user_id', $decoded->uid)->where('video_id', $video_[$l]['video_id'])->first();

                    if($userVideo_){
                        $userVideo++;

                        $score_raw += $userVideo_['score'];
                        $score_final = $score_raw / count($video_);

                        $data['course'][$i]['score'] = $score_final;
                        $data['course'][$i]['progress'] = "Complete";
                    }else{
                        $data['course'][$i]['score'] = null;
                        $data['course'][$i]['progress'] = "Inprogress";
                    }
                }
            }

            if($data){
                return $this->respond($data);
            }else{
                return $this->failNotFound('Anda Tidak Memiliki Course');
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data tidak ditemukan');
    }

    public function getSertifikat($course_id = null){
        $modelUserCourse = new UserCourse();
        $modelVideo = new Video();
        $modelUserVideo = new UserVideo();
        $modelCourse = new Course;
        $modelVideoCategory = new VideoCategory;

        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);

            $course = $modelUserCourse
                ->where('user_course.course_id', $course_id)
                ->where('user_course.user_id', $decoded->uid)
                ->join('users', 'user_course.user_id=users.id')
                ->join('course', 'user_course.course_id=course.course_id')
                ->join('video_category', 'user_course.course_id=video_category.course_id')
                ->select('users.id, users.fullname, course.title, user_course.created_at, video_category.video_category_id')
                ->findAll();

            $data['course'] = $course;

            for ($l = 0; $l < count($course); $l++) {
                $video = $modelVideo
                    ->where('video_category_id', $course[$l]['video_category_id'])
                    ->select('video.*')
                    ->findAll();
    
                $data['course'][$l]['video'] = $video;

                for ($i = 0; $i < count($video); $i++) {
                    $uservideo = $modelUserVideo
                        ->where('video_id', $video[$i]['video_id'])
                        ->where('user_id', $course[$l]['id'])
                        ->select('user_video.score')
                        ->findAll();
                    
                    if ($uservideo == null) {
                        $uservideo = null;
                    }else {
                        $uservideo = $uservideo;
                    }
                    
                    $data['course'][$l]['video'][$i]['hasil_score'] = $uservideo;
                }

                for ($x = 0; $x < count($video); $x++) {
                    $resume = $this->resume
                        ->where('video_id', $video[$x]['video_id'])
                        ->where('user_id', $course[$l]['id'])
                        ->select('resume.resume')
                        ->findAll();
        
                    if ($resume == null) {
                        $resume = null;
                    }else {
                        $resume = $resume;
                    }

                    $data['course'][$l]['video'][$x]['resume_video'] = $resume;
                }
            }

            $userCourse = $modelUserCourse->where('user_id', $decoded->uid)->where('user_course.course_id', $course_id)->findAll();

            if($userCourse == null){
                return $this->failNotFound('Anda Tidak Memiliki Course');
            }
            $course = $userCourse;
            $score_raw = 0;
            $score_final = 0;
            for ($i = 0; $i < count($userCourse); $i++) {
                $course_ = $modelCourse->where('course_id', $userCourse[$i]['course_id'])->first();
                $course[$i] = $course_;

                $videoCat_ = $modelVideoCategory->where('course_id', $userCourse[$i]['course_id'])->first();
                $video_ = $modelVideo->where('video_category_id', $videoCat_['video_category_id'])->findAll();

                $userVideo = 0;
                for($l = 0; $l < count($video_); $l++){
                    $userVideo_ = $modelUserVideo->where('user_id', $decoded->uid)->where('video_id', $video_[$l]['video_id'])->first();

                    if($userVideo_){
                        $userVideo++;

                        $score_raw += $userVideo_['score'];
                        $score_final = $score_raw / count($video_);

                        $data['course'][$i]['score'] = $score_final;
                        $data['course'][$i]['progress'] = "Complete";
                    }else{
                        $data['course'][$i]['score'] = null;
                        $data['course'][$i]['progress'] = "Inprogress";
                    }
                }
            }

            if($data){
                return $this->respond($data);
            }else{
                return $this->failNotFound('Anda Tidak Memiliki Course');
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data tidak ditemukan');
    }

    public function delete($id = null){
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);

            $data = $this->resume->where('resume_id', $id)->findAll();
            if($data){
            $this->resume->delete($id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'resume berhasil dihapus'
                    ]
                ];
            }
            return $this->respondDeleted($response);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data resume tidak ditemukan');
    }
}