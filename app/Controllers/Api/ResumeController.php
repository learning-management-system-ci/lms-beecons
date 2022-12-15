<?php

namespace App\Controllers\Api;

use App\Controllers\Api\UserController as ApiUserController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Resume;
use App\Models\UserCourse;
use App\Models\Video;
use App\Models\UserVideo;
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
            
            $dataresume = $this->resume->findAll();

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

            if($this->validate($rules, $messages)) {
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

    public function getSertifikat($course_id = null){
        $modelUserCourse = new UserCourse();
        $modelVideo = new Video();
        $modelUserVideo = new UserVideo();

        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);

            // $resume = $this->resume
            //     ->where('resume.user_id', $decoded->uid)
            //     ->where('course.course_id', $course_id)
            //     ->join('course_bundling', 'bundling.bundling_id=course_bundling.bundling_id')
            //     // ->join('course', 'course_bundling.course_id=course.course_id')
            //     // ->join('course_category', 'course.course_id=course_category.course_id')
            //     // ->join('video_category', 'course.course_id=video_category.course_id')
            //     ->select('resume.*')
            //     // ->orderBy('bundling.bundling_id', 'DESC')
            //     ->findAll();

            // $this->usercontroller->learningProgress();

            $course = $modelUserCourse
                ->where('user_course.course_id', $course_id)
                ->where('user_course.user_id', $decoded->uid)
                ->join('users', 'user_course.user_id=users.id')
                ->join('course', 'user_course.course_id=course.course_id')
                ->join('video_category', 'user_course.course_id=video_category.course_id')
                ->select('users.id, users.fullname, course.title, user_course.created_at, video_category.video_category_id')
                ->findAll();

            // $video = $modelUserCourse
            //     ->where('user_course.course_id', $course_id)
            //     ->where('user_course.user_id', $decoded->uid)
            //     ->join('users', 'user_course.user_id=users.id')
            //     ->join('course', 'user_course.course_id=course.course_id')
            //     ->join('video_category', 'user_course.course_id=video_category.course_id')
            //     ->join('video', 'video_category.video_category_id=video.video_category_id')
            //     // ->join('user_video', 'video.video_id=user_video.video_id')
            //     ->select('video.*')
            //     ->findAll();

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