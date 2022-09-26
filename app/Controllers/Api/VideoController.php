<?php

namespace App\Controllers\Api;
use CodeIgniter\API\ResponseTrait;
use App\Models\Video;
use App\Models\Course;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;

class VideoController extends ResourceController {
    use ResponseTrait;
    private $videoModel=NULL;
	private $courseModel=NULL;


	function __construct(){
		$this->videoModel = new Video();
		$this->courseModel = new Course();
	}

	public function index() {

	}

    public function create() {
		$key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
			$decoded = JWT::decode($token, $key, ['HS256']);
			$rules = [
				"course_id" => "required",
				"title" => "required",
				"video" => "uploaded[video]|mime_in[video,video/mp4,video/3gp,video/flv]|max_size[video,262144]",
				"order" => "required",
			];
			$messages = [
				"course_id" => [
					"required" => "{field} tidak boleh kosong"
				],
				"title" => [
					"required" => "{field} tidak boleh kosong"
				],
				"video" => [
					'uploaded' => '{field} tidak boleh kosong',
					'mime_in' => 'File Extention Harus Berupa mp4, 3gp, atau flv',
					'max_size' => 'Ukuran File Maksimal 2 MB'
				],
				"order" => [
					"required" => "{field} tidak boleh kosong"
				],
			];
			if (!$this->validate($rules, $messages)) return $this->fail($this->validator->getErrors());
			
			$verifyCourse = $this->courseModel->where("course_id", $this->request->getVar('course_id'))->first();
			if(!$verifyCourse) {
				return $this->failNotFound('Course tidak ditemukan');
			} else {
				$dataVideo = $this->request->getFile('video');
				$fileName = $dataVideo->getRandomName();
				$this->videoModel->insert([
					'course_id' => $this->request->getVar("course_id"),
					'title' => $this->request->getVar("title"),
					'order' => $this->request->getVar("order"),
					'video' => $fileName
				]);
				$dataVideo->move('upload/course-video/', $fileName);
	
				$response = [
					'status' => 200,
					'success' => 200,
					'message' => 'Video berhasil diupload',
					'data' => []
				];
			}
			return $this->respondCreated($response);
		} catch (\Throwable $th) {
            return $this->fail('Akses token tidak sesuai');
        }
    }

	public function update($id = null) {
		$key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
			$decoded = JWT::decode($token, $key, ['HS256']);
			$rules = [
				"course_id" => "required",
				"title" => "required",
				"video" => "uploaded[video]|mime_in[video,video/mp4,video/3gp,video/flv]|max_size[video,262144]",
				"order" => "required",
			];
	
			$messages = [
				"course_id" => [
					"required" => "{field} tidak boleh kosong"
				],
				"title" => [
					"required" => "{field} tidak boleh kosong"
				],
				"video" => [
					'uploaded' => '{field} tidak boleh kosong',
					'mime_in' => 'File Extention Harus Berupa mp4, 3gp, atau flv',
					'max_size' => 'Ukuran File Maksimal 2 MB'
				],
				"order" => [
					"required" => "{field} tidak boleh kosong"
				],
			];
			if (!$this->validate($rules, $messages)) return $this->fail($this->validator->getErrors());
			
			$verifyCourse = $this->courseModel->where("course_id", $this->request->getVar('course_id'))->first();
			if(!$verifyCourse) {
				return $this->failNotFound('Course tidak ditemukan');
			} else {
				$findVideo = $this->videoModel->find($id);
				if(!$findVideo){
					return $this->failNotFound('Data video tidak ditemukan');
				}
				$oldVideo = $findVideo['video'];
				$dataVideo = $this->request->getFile('video');
				if ($dataVideo->isValid() && !$dataVideo->hasMoved()) {
					if (file_exists("upload/course-video/".$oldVideo)) {
						unlink ("upload/course-video/".$oldVideo);
					}
					$fileName = $dataVideo->getRandomName();
					$dataVideo->move('upload/course-video/', $fileName);
				} else {
					$fileName = $oldVideo['video'];
				}
	
				$data = [
					'course_id' => $this->request->getVar("course_id"),
					'title' => $this->request->getVar("title"),
					'order' => $this->request->getVar("order"),
					'video' => $fileName
				];
				$this->videoModel->update($id, $data);
	
				$response = [
					'status' => 200,
					'success' => 200,
					'message' => 'Video berhasil diperbarui',
					'data' => []
				];
			}
			return $this->respond($response);
		} catch (\Throwable $th) {
            return $this->fail('Akses token tidak sesuai');
        }
	}

	public function delete($id = null) {
		$key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
			$decoded = JWT::decode($token, $key, ['HS256']);
			$data = $this->videoModel->find($id);
			if($data){
				$videoName = $data['video'];
				unlink ("upload/course-video/".$videoName);
				$this->videoModel->delete($id);
				$response = [
					'status'   => 200,
					'success'    => 200,
					'messages' => [
						'success' => 'Video berhasil dihapus'
					]
				];
				return $this->respondDeleted($response); 
			} else {
				return $this->failNotFound('Data Video tidak ditemukan');
			}
		} catch (\Throwable $th) {
            return $this->fail('Akses token tidak sesuai');
        }
    }
}
