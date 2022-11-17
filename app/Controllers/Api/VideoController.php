<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use App\Models\Video;
use App\Models\Course;
use App\Models\Users;
use App\Models\Quiz;
use App\Models\UserVideo;
use App\Models\VideoCategory;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;

class VideoController extends ResourceController
{
	use ResponseTrait;
	private $videoModel = NULL;
	private $courseModel = NULL;


	function __construct()
	{
		$this->videoModel = new Video();
		$this->courseModel = new Course();
		$this->userVideoModel = new UserVideo();
		$this->videoCategory = new VideoCategory();
	}

	public function index($id = null)
	{
		$data = $this->videoModel->where('video_id', $id)->first();

		$path_thumbnail = site_url() . 'upload/course-video/thumbnail';
		$path_video = site_url() . 'upload/course-video/';

		$data = [
			"video_id" => $data['video_id'],
			"video_category_id" => $data['video_category_id'],
			"title" =>  $data['title'],
			"thumbnail" => $path_thumbnail . $data['thumbnail'],
			"video" => $path_video . $data['video'],
			"order" =>  $data['order'],
			"created_at" => $data['created_at'],
			"updated_at" => $data['updated_at'],
		];

		$modelQuiz = new Quiz;
		$dataQuiz = $modelQuiz->where('video_id', $id)->first();

		$quiz = [];
		// for($i = 0; $i < count($dataQuiz); $i++){
		// 	array_push($quiz, $dataQuiz[$i]);
		// 	// $quizRaw = [];

		// 	$question = json_decode($dataQuiz[$i]['question']);
		// 	for($l = 0; $l < count($question); $l++){
		// 		unset($question[$l]->is_valid);
		// 	}
		// 	// array_push($quizRaw, $question);
		// 	unset($dataQuiz[$i]['question']);
		// 	$dataQuiz[$i]['soal'] = $question;
		// }
		$question = json_decode($dataQuiz['question']);
		for ($l = 0; $l < count($question); $l++) {
			unset($question[$l]->is_valid);
		}
		// array_push($quizRaw, $question);
		unset($dataQuiz['question']);
		$dataQuiz['soal'] = $question;
		$data['quiz'] = $dataQuiz;
		return $this->respond($data);
	}

	public function answer($id = null)
	{
		$key = getenv('TOKEN_SECRET');
		$header = $this->request->getServer('HTTP_AUTHORIZATION');
		if (!$header) return $this->failUnauthorized('Akses token diperlukan');
		$token = explode(' ', $header)[1];

		try {
			$decoded = JWT::decode($token, $key, ['HS256']);

			$rules = [
				"answer" => "required",
			];
			$messages = [
				"answer" => [
					"required" => "{field} tidak boleh kosong"
				],
			];
			if (!$this->validate($rules, $messages)) return $this->fail($this->validator->getErrors());

			$modelQuiz = new Quiz;
			$dataQuiz = $modelQuiz->where('video_id', $id)->first();
			$question = json_decode($dataQuiz['question']);

			if (count($this->request->getVar('answer')) != count($question)) {
				return $this->fail('Mohon jawab semua soal yang ada', 400);
			}

			$jawaban = $this->request->getVar('answer');
			$salah = 0;

			for ($i = 0; $i < count($question); $i++) {
				if ($jawaban[$i]->answer != $question[$i]->is_valid) {
					// for debugging
					// return $this->fail('Jawaban ke ' . $i+1 .' salah', 400);
					$salah++;
				}
			}

			$scoreRaw = round((count($jawaban) - $salah) / count($jawaban), 6);
			$score = intval($scoreRaw * 100);
			if ($score == 1) {
				$score = 100;
			}

			$userVideo = $this->userVideoModel->where('user_id', $decoded->uid)->where('video_id', $id)->first();

			// return $this->fail($userVideo, 400);
			if (!$userVideo && $score >= 50) {
				$this->userVideoModel->insert([
					'user_id' => $decoded->uid,
					'video_id' => $id,
					'score' => $score
				]);
			} elseif ($userVideo && $score >= 50) {
				$this->userVideoModel->where('user_id', $decoded->uid)->where('video_id', $id)
					->set('score', $score)
					->update();
			}

			$pass = false;
			if ($score >= 50) {
				$pass = true;
			}
			$response = [
				'status' => 200,
				'success' => 200,
				'pass' => $pass,
			];
			return $this->respondCreated($response);
		} catch (\Throwable $th) {
			return $this->fail($th->getMessage());
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
			if ($data['role'] == 'member' || $data['role'] == 'partner' || $data['role'] == 'mentor') {
				return $this->fail('Tidak dapat di akses selain admin & author', 400);
			}

			$rules = [
				"video_category_id" => "required",
				"title" => "required",
				"thumbnail" => "is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png]|max_size[thumbnail,262144]",
				"video" => "mime_in[video,video/mp4,video/3gp,video/flv]|max_size[video,262144]",
				"order" => "required",
			];
			$messages = [
				"video_category_id" => [
					"required" => "{field} tidak boleh kosong"
				],
				"title" => [
					"required" => "{field} tidak boleh kosong"
				],
				"thumbnail" => [
					'mime_in' => 'File Extention Harus Berupa jpg, jpeg, png atau webp',
					'max_size' => 'Ukuran File Maksimal 2 MB'
				],
				"video" => [
					// 'uploaded' => '{field} tidak boleh kosong',
					'mime_in' => 'File Extention Harus Berupa mp4, 3gp, atau flv',
					'max_size' => 'Ukuran File Maksimal 2 MB'
				],
				"order" => [
					"required" => "{field} tidak boleh kosong"
				],
			];
			if (!$this->validate($rules, $messages)) return $this->fail($this->validator->getErrors());

			$verifyCourse = $this->videoCategory->where("video_category_id", $this->request->getVar('video_category_id'))->first();
			if (!$verifyCourse) {
				return $this->failNotFound('Course tidak ditemukan');
			} else {
				$dataVideo = $this->request->getVar('video_url');

				$dataThumbnail = $this->request->getFile('thumbnail');
				$thumbnailFileName = $dataThumbnail->getRandomName();
				$dataThumbnail->move('upload/course-video/thumbnail/', $thumbnailFileName);

				if (empty($dataVideo)) {
					$dataVideo = $this->request->getFile('video');
					$fileName = $dataVideo->getRandomName();
					$dataVideo->move('upload/course-video/', $fileName);
				} else {
					$fileName = $dataVideo;
				}

				$this->videoModel->insert([
					'video_category_id' => $this->request->getVar("video_category_id"),
					'title' => $this->request->getVar("title"),
					'thumbnail' => $thumbnailFileName,
					'order' => $this->request->getVar("order"),
					'video' => $fileName
				]);

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
			if ($data['role'] == 'member' || $data['role'] == 'partner' || $data['role'] == 'mentor') {
				return $this->fail('Tidak dapat di akses selain admin & author', 400);
			}

			$rules = [
				"video_category_id" => "required",
				"title" => "required",
				"thumbnail" => "is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png]|max_size[thumbnail,262144]",
				"video" => "mime_in[video,video/mp4,video/3gp,video/flv]|max_size[video,262144]",
				"order" => "required",
			];

			$messages = [
				"video_category_id" => [
					"required" => "{field} tidak boleh kosong"
				],
				"title" => [
					"required" => "{field} tidak boleh kosong"
				],
				"thumbnail" => [
					'mime_in' => 'File Extention Harus Berupa jpg, jpeg, png atau webp',
					'max_size' => 'Ukuran File Maksimal 2 MB'
				],
				"video" => [
					// 'uploaded' => '{field} tidak boleh kosong',
					'mime_in' => 'File Extention Harus Berupa mp4, 3gp, atau flv',
					'max_size' => 'Ukuran File Maksimal 2 MB'
				],
				"order" => [
					"required" => "{field} tidak boleh kosong"
				],
			];

			if (!$this->validate($rules, $messages)) return $this->fail($this->validator->getErrors());

			$verifyCourse = $this->videoCategory->where("video_category_id", $this->request->getVar('video_category_id'))->first();
			if (!$verifyCourse) {
				return $this->failNotFound('Course tidak ditemukan');
			} else {
				$findVideo = $this->videoModel->find($id);
				if (!$findVideo) {
					return $this->failNotFound('Data video tidak ditemukan');
				}
				$oldThumbnail = $findVideo['thumbnail'];
				$oldVideo = $findVideo['video'];

				$dataThumbnail = $this->request->getFile('thumbnail');
				$thumbnailFileName = $dataThumbnail->getRandomName();

				if (file_exists("upload/course-video/thumbnail/" . $oldThumbnail)) {
					if ($oldThumbnail != '') {
						print_r("te1s");
						unlink("upload/course-video/thumbnail/" . $oldThumbnail);
						$dataThumbnail->move('upload/course-video/thumbnail/', $thumbnailFileName);
					} else {
						print_r("te32s");
						$dataThumbnail->move('upload/course-video/thumbnail/', $thumbnailFileName);
					}
				} else {
					print_r("te2s");
					$dataThumbnail->move('upload/course-video/thumbnail/', $thumbnailFileName);
				}

				$dataVideo = $this->request->getVar('video_url');

				if (empty($dataVideo)) {

					$dataVideo = $this->request->getFile('video');
					if ($dataVideo->isValid() && !$dataVideo->hasMoved()) {
						if (file_exists("upload/course-video/" . $oldVideo)) {
							unlink("upload/course-video/" . $oldVideo);
						}
						$fileName = $dataVideo->getRandomName();
						$dataVideo->move('upload/course-video/', $fileName);
					} else {
						$fileName = $oldVideo['video'];
					}
				} else {
					$fileName = $dataVideo;
				}

				$data = [
					'video_category_id' => $this->request->getVar("video_category_id"),
					'title' => $this->request->getVar("title"),
					'thumbnail' => $thumbnailFileName,
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
			if ($data['role'] == 'member' || $data['role'] == 'partner' || $data['role'] == 'mentor') {
				return $this->fail('Tidak dapat di akses selain admin & author', 400);
			}

			$data = $this->videoModel->find($id);
			if ($data) {
				$videoName = $data['video'];
				unlink("upload/course-video/" . $videoName);
				$this->videoModel->delete($id);
				$response = [
					'status'   => 200,
					'success'    => 200,
					'messages' => [
						'success' => 'Video berhasil dihapus'
					]
				];
			}
		} catch (\Throwable $th) {
			return $this->fail($th->getMessage());
		}
		return $this->failNotFound('Data Video tidak ditemukan');
	}
}
