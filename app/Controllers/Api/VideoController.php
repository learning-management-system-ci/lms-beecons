<?php

namespace App\Controllers\Api;
use CodeIgniter\API\ResponseTrait;
use App\Models\Video;
use App\Models\Course;
use App\Models\Users;
use App\Models\Quiz;
use App\Models\VideoCategory;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;

class VideoController extends ResourceController {
    use ResponseTrait;
    private $videoModel=NULL;
	private $courseModel=NULL;


	function __construct(){
		$this->videoModel = new Video();
		$this->courseModel = new Course();
		$this->videoCategory = new VideoCategory();
	}

	public function index($id = null) {
		$data = $this->videoModel
			->where('video_id', $id)
			->first();

		$modelQuiz = new Quiz;
		$dataQuiz = $modelQuiz->where('video_id', $id)->findAll();

		for($i = 0; $i < count($dataQuiz); $i++){
			$data['quiz'][$i] = $dataQuiz[$i];
		}

		return $this->respond($data);
	}

  public function create() {
		$key = getenv('TOKEN_SECRET');
		$header = $this->request->getServer('HTTP_AUTHORIZATION');
		if (!$header) return $this->failUnauthorized('Akses token diperlukan');
		$token = explode(' ', $header)[1];

		try {
				$decoded = JWT::decode($token, $key, ['HS256']);
				$user = new Users;

			// cek role user
			$data = $user->select('role')->where('id', $decoded->uid)->first();
			if($data['role'] != 'admin'){
					return $this->fail('Tidak dapat di akses selain admin', 400);
			}

				$rules = [
					"video_category_id" => "required",
					"title" => "required",
					"video" => "uploaded[video]|mime_in[video,video/mp4,video/3gp,video/flv]|max_size[video,262144]",
					"order" => "required",
				];
				$messages = [
					"video_category_id" => [
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
				
				$verifyCourse = $this->videoCategory->where("video_category_id", $this->request->getVar('video_category_id'))->first();
				if(!$verifyCourse) {
					return $this->failNotFound('Course tidak ditemukan');
				} else {
					$dataVideo = $this->request->getFile('video');
					$fileName = $dataVideo->getRandomName();
					$this->videoModel->insert([
						'video_category_id' => $this->request->getVar("video_category_id"),
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
			return $this->fail($th->getMessage());
		}
	}

	public function update($id = null) {
		$key = getenv('TOKEN_SECRET');
    $header = $this->request->getServer('HTTP_AUTHORIZATION');
  	if (!$header) return $this->failUnauthorized('Akses token diperlukan');
	  $token = explode(' ', $header)[1];

    try {
			$decoded = JWT::decode($token, $key, ['HS256']);
			$user = new Users;

    	// cek role user
	    $data = $user->select('role')->where('id', $decoded->uid)->first();
	    if($data['role'] != 'admin'){
	      return $this->fail('Tidak dapat di akses selain admin', 400);
      }

			$rules = [
				"video_category_id" => "required",
				"title" => "required",
				"video" => "uploaded[video]|mime_in[video,video/mp4,video/3gp,video/flv]|max_size[video,262144]",
				"order" => "required",
			];
	
			$messages = [
				"video_category_id" => [
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
			
			$verifyCourse = $this->courseModel->where("video_category_id", $this->request->getVar('video_category_id'))->first();
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
					'video_category_id' => $this->request->getVar("video_category_id"),
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
      return $this->fail($th->getMessage());
    }
	}

	public function delete($id = null) {
		$key = getenv('TOKEN_SECRET');
  	$header = $this->request->getServer('HTTP_AUTHORIZATION');
	  if (!$header) return $this->failUnauthorized('Akses token diperlukan');
	  $token = explode(' ', $header)[1];

	  try {
			$decoded = JWT::decode($token, $key, ['HS256']);
			$user = new Users;

    	// cek role user
	    $data = $user->select('role')->where('id', $decoded->uid)->first();
	    if($data['role'] != 'admin'){
	      return $this->fail('Tidak dapat di akses selain admin', 400);
      }

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
      return $this->fail($th->getMessage());
    }
  }
}
