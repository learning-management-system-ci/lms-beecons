<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserVideo;
use App\Models\Course;
use App\Models\Video;
use App\Models\VideoCategory;
use App\Models\Users;
use Firebase\JWT\JWT;

class UserVideoController extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->uservideo = new UserVideo();
        $this->course = new Course();
        $this->video = new Video();
        $this->videocategory = new VideoCategory();
    }

    public function index(){
        $data = $this->uservideo->getUserVideo();
        $datauservideo = [];
        foreach($data as $value) {
            $datauservideo[] = [
                'user_video_id' => $value['user_video_id'],
                'video' => $this->uservideo->getDataVideo($data_video_id = $value['video_id']),
                'user' => $this->uservideo->getDataUser($data_user_id = $value['user_id']),
                'score' => $value['score'],
                'created_at' => $value['created_at'],
                'updated_at' => $value['updated_at'],
            ];
        }
        return $this->respond($datauservideo);
    }

    public function show($id = null){
        $data = $this->uservideo->getShow($id);
        $datauservideo = [];
        foreach($data as $value) {
            $datauservideo[] = [
                'user_video_id' => $value['user_video_id'],
                'video' => $this->uservideo->getDataVideo($data_video_id = $value['video_id']),
                'user' => $value['user_id'],
                'score' => $value['score'],
                'created_at' => $value['created_at'],
                'updated_at' => $value['updated_at'],
            ];
        }
        if($datauservideo){
            return $this->respond($datauservideo);
        }else{
            return $this->failNotFound('Data User Video tidak ditemukan');
        }
    }

    public function showuser($course_id = null, $user_id = null){
        $data = $this->uservideo->getShowUser($user_id);
        $course = $this->course
            ->where('course_id', $course_id)
            ->find();
        $videocategory = $this->videocategory
            ->where('course_id', $course_id)
            ->findAll();
            
        for($i = 0; $i < count($course); $i++){
            for($k = 0; $k < count($videocategory); $k++){
                $course[$i]['video'][$k] = $videocategory[$k];
                $userVideo = $this->uservideo
                    ->select('user_video.score')
                    ->join('users', 'users.id = user_video.user_id')
                    ->join('video', 'video.video_id = user_video.video_id')
                    ->where('users.id', $user_id)
                    ->where('video.video_id', $videocategory[$k]['video_id'])
                    ->find();

                if(isset($userVideo[0])){
                    $course[$i]['video'][$k]['score'] = $userVideo[0]['score'];
                }else{
                    $course[$i]['video'][$k]['score'] = null;
                }
            }
        }

        $datausers = [];
        foreach($data as $value) {
            $datausers[] = [
                'user_video_id' => $value['user_video_id'],
                'user' => $value['user_id'],
                'course' => $course,
                'created_at' => $value['created_at'],
                'updated_at' => $value['updated_at'],
            ];
        }

        if($datausers){
            return $this->respond($datausers);
        }else{
            return $this->failNotFound('Data User Video tidak ditemukan');
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
                'video_id' => 'required',
                'score' => 'required|numeric'
            ];

            $messages = [
                "user_id" => [
                    "required" => "{field} tidak boleh kosong",
                ],
                "video_id" => [
                    "required" => "{field} tidak boleh kosong",
                ],
                "score" => [
                    "required" => "{field} tidak boleh kosong",
                    "numeric" => "{field} harus berisi nomor"
                ],
            ];

            if($this->validate($rules, $messages)) {
                $dataUserVideo = [
                    'user_id' => $this->request->getVar('user_id'),
                    'video_id' => $this->request->getVar('video_id'),
                    'score' => $this->request->getVar('score'),
                ];
                $this->uservideo->insert($dataUserVideo);

                $response = [
                    'status'   => 201,
                    'success'    => 201,
                    'messages' => [
                        'success' => 'User Video berhasil dibuat'
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
                'video_id' => 'required',
                'score' => 'required|numeric'
            ];

            $messages = [
                "user_id" => [
                    "required" => "{field} tidak boleh kosong",
                ],
                "video_id" => [
                    "required" => "{field} tidak boleh kosong",
                ],
                "score" => [
                    "required" => "{field} tidak boleh kosong",
                    "numeric" => "{field} harus berisi nomor"
                ],
            ];

            $data = [
                "user_id" => $input["user_id"],
                "video_id" => $input["video_id"],
                "score" => $input["score"],
            ];

            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'User Video berhasil diperbarui'
                ]
            ];

            $cek = $this->uservideo->where('user_video_id', $id)->findAll();

            if(!$cek){
                return $this->failNotFound('Data user video tidak ditemukan');
            }

            if (!$this->validate($rules, $messages)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            if ($this->uservideo->update($id, $data)){
                return $this->respond($response);
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
		return $this->failNotFound('Data user video tidak ditemukan');
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
            
            $data = $this->uservideo->where('user_video_id', $id)->findAll();
            if($data){
            $this->uservideo->delete($id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'User Video berhasil dihapus'
                    ]
                ];
            }
            return $this->respondDeleted($response);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data User Video tidak ditemukan');
    }
}
