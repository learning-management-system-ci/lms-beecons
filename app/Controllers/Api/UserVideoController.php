<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserVideo;
use App\Models\Course;
use App\Models\Video;

class UserVideoController extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->uservideo = new UserVideo();
        $this->course = new Course();
        $this->video = new Video();
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
        $video = $this->video
            ->where('course_id', $course_id)
            ->findAll();
        // $datavideo = $this->video->getDataVideo($course_id);
        // $datavideo = $this->video
        //     ->select('video.video_id, video.course_id, video.title as vid_title, video.video, video.order, user_video.score')
        //     ->join('course','course.course_id=video.course_id')
        //     ->join('user_video','user_video.video_id=video.video_id')
        //     ->orderBy('course.course_id', 'DESC')
        //     ->where('course.course_id', $id)
        //     ->findAll();
        
        // $datavideos = [];
        // foreach($datavideo as $valuevideo) {
        //     $datavideos[] = [
        //         'video_id' => $valuevideo['video_id'],
        //         'course_id' => $valuevideo['course_id'],
        //         'vid_title' => $valuevideo['vid_title'],
        //         'video' => $valuevideo['video'],
        //         'order' => $valuevideo['order'],
        //         'score' => $valuevideo['score'],
        //     ];
        // }
        // $datausers = [];
        // foreach($data as $value) {
        //     $datausers[] = [
        //         'user_video_id' => $value['user_video_id'],
        //         'user' => $value['user_id'],
        //         'course' => [
        //             'course_id' => $course_id,
        //             // 'video' => $this->video->getDataVideo($data_video_id = $value['video_id'], $data_course_id = $course_id),
        //             'video' => $datavideo,
        //         ],
        //         'created_at' => $value['created_at'],
        //         'updated_at' => $value['updated_at'],
        //     ];
        // }
        // if($datausers){
        //     return $this->respond($datausers);
        // }else{
        //     return $this->failNotFound('Data User Video tidak ditemukan');
        // }
        for($i = 0; $i < count($course); $i++){
            for($k = 0; $k < count($video); $k++){
                $course[$i]['video'][$k] = $video[$k];
                $userVideo = $this->uservideo
                    ->select('user_video.score')
                    ->join('users', 'users.id = user_video.user_id')
                    ->join('video', 'video.video_id = user_video.video_id')
                    ->where('users.id', $user_id)
                    ->where('video.video_id', $video[$k]['video_id'])
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
        $rules = [
            'user_id' => 'required|numeric',
            'video_id' => 'required|numeric',
            'score_id' => 'required|numeric'
        ];

        $messages = [
            "user_id" => [
                "required" => "{field} tidak boleh kosong",
                "numeric" => "{field} harus berisi nomor"
            ],
            "video_id" => [
                "required" => "{field} tidak boleh kosong",
                "numeric" => "{field} harus berisi nomor"
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

        return $this->respondCreated($response);    
    }

    public function update($id = null){
		$input = $this->request->getRawInput();

		$rules = [
            'user_id' => 'required|numeric',
            'video_id' => 'required|numeric',
            'score_id' => 'required|numeric'
        ];

        $messages = [
            "user_id" => [
                "required" => "{field} tidak boleh kosong",
                "numeric" => "{field} harus berisi nomor"
            ],
            "video_id" => [
                "required" => "{field} tidak boleh kosong",
                "numeric" => "{field} harus berisi nomor"
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

		$cek = $this->uservideo->where('uservideo_id', $id)->findAll();

		if(!$cek){
			return $this->failNotFound('Data user video tidak ditemukan');
		}

		if (!$this->validate($rules, $messages)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

		if ($this->bundling->update($id, $data)){
			return $this->respond($response);
		}
		return $this->failNotFound('Data user video tidak ditemukan');
	}

    public function delete($id = null){
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
        return $this->respondDeleted($response);
        }else{
        return $this->failNotFound('Data User Video tidak ditemukan');
        }
    }
}
