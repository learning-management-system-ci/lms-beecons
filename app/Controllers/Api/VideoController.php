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

		$path_thumbnail = site_url() . 'upload/course-video/thumbnail/';
		$path_video = site_url() . 'upload/course-video/';

		if (!$data) {
			return $this->failNotFound('Data Video tidak ditemukan');
		}

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
		if ($dataQuiz != null) {
			$question = json_decode($dataQuiz['question']);
			for ($l = 0; $l < count($question); $l++) {
				unset($question[$l]->is_valid);
			}
			// array_push($quizRaw, $question);
			unset($dataQuiz['question']);
			shuffle($question);

			$dataQuiz['soal'] = [];

			if (count($question) >= 5) {
				$rand_keys = array_rand($question, 5);
				for ($i = 0; $i < count($rand_keys); $i++) {
					array_push($dataQuiz['soal'], $question[$rand_keys[$i]]);
				}
			} else {
				$rand_keys = array_rand($question, count($question));
				for ($i = 0; $i < count($rand_keys); $i++) {
					array_push($dataQuiz['soal'], $question[$rand_keys[$i]]);
				}
			}
		} else {
			$dataQuiz['soal'] = null;
		}
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
				'score' => $score
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
			if ($data['role'] == 'member') {
				return $this->fail('Tidak dapat di akses oleh member', 400);
			}

			$rules = [
				"video_category_id" => "required",
				"title" => "required",
				"thumbnail" => "uploaded[thumbnail]|is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png]|max_size[thumbnail,4000]",
				"video" => "mime_in[video,video/mp4,video/3gp,video/flv]|max_size[video,262144]",
				// "video" => "max_size[video,262144]",
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
					'uploaded' => '{field} tidak boleh kosong',
					'mime_in' => '{field} Harus Berupa jpg, jpeg, png atau webp',
					'max_size' => 'Ukuran {field} Maksimal 4 MB'
				],
				"video" => [
					// 'uploaded' => '{field} tidak boleh kosong',
					'mime_in' => '{field} Harus Berupa mp4, 3gp, atau flv',
					'max_size' => 'Ukuran {field} Maksimal 256 MB'
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
			if ($data['role'] == 'member') {
				return $this->fail('Tidak dapat di akses oleh member', 400);
			}

			$rules_a = [
				"video_category_id" => "required",
				"title" => "required",
				"order" => "required",
			];

			$rules_b = [
				"thumbnail" => "uploaded[thumbnail]|is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png]|max_size[thumbnail,4000]",
			];

			$rules_c = [
				"video" => "uploaded[video]|mime_in[video,video/mp4,video/3gp,video/flv]|max_size[video,262144]",
			];

			$messages_a = [
				"video_category_id" => [
					"required" => "{field} tidak boleh kosong"
				],
				"title" => [
					"required" => "{field} tidak boleh kosong"
				],
				"order" => [
					"required" => "{field} tidak boleh kosong"
				],
			];

			$messages_b = [
				"thumbnail" => [
					'uploaded' => '{field} tidak boleh kosong',
					'mime_in' => 'File Extention Harus Berupa jpg, jpeg, png atau webp',
					'max_size' => 'Ukuran File Maksimal 4 MB'
				],
			];

			$messages_c = [
				"video" => [
					'uploaded' => '{field} tidak boleh kosong',
					'mime_in' => 'File Extention Harus Berupa mp4, 3gp, atau flv',
					'max_size' => 'Ukuran File Maksimal 256 MB'
				],
			];

			$verifyCourse = $this->videoCategory->where("video_category_id", $this->request->getVar('video_category_id'))->first();

			if (!$verifyCourse) {
				return $this->failNotFound('Course tidak ditemukan');
			}

			$findvideo = $this->videoModel->where('video_id', $id)->first();
			if ($findvideo) {
				if ($this->validate($rules_a, $messages_a)) {
					if ($this->validate($rules_b, $messages_b)) {
						$oldThumbnail = $findvideo['thumbnail'];
						$dataThumbnail = $this->request->getFile('thumbnail');

						if ($dataThumbnail->isValid() && !$dataThumbnail->hasMoved()) {
							if (file_exists("upload/course-video/thumbnail/" . $oldThumbnail)) {
								unlink("upload/course-video/thumbnail/" . $oldThumbnail);
							}
							$thumbnailFileName = $dataThumbnail->getRandomName();
							$dataThumbnail->move('upload/course-video/thumbnail/', $thumbnailFileName);
						} else {
							$thumbnailFileName = $oldThumbnail['thumbnail'];
						}

						$dataVideo = $this->request->getVar('video_url');

						if ($this->validate($rules_c, $messages_c) || $dataVideo != null) {
							$oldVideo = $findvideo['video'];
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
								'status'   => 201,
								'success'    => 201,
								'messages' => [
									'success' => 'Video berhasil diperbarui'
								]
							];
						}

						$data = [
							'video_category_id' => $this->request->getVar("video_category_id"),
							'title' => $this->request->getVar("title"),
							'thumbnail' => $thumbnailFileName,
							'order' => $this->request->getVar("order"),
						];

						$this->videoModel->update($id, $data);

						$response = [
							'status'   => 201,
							'success'    => 201,
							'messages' => [
								'success' => 'Video berhasil diperbarui'
							]
						];
					}

					$dataVideo = $this->request->getVar('video_url');

					if ($this->validate($rules_c, $messages_c) || $dataVideo != null) {
						$oldVideo = $findvideo['video'];
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
							'order' => $this->request->getVar("order"),
							'video' => $fileName
						];

						$this->videoModel->update($id, $data);

						$response = [
							'status'   => 201,
							'success'    => 201,
							'messages' => [
								'success' => 'Video berhasil diperbarui'
							]
						];
					}

					$data = [
						'video_category_id' => $this->request->getVar("video_category_id"),
						'title' => $this->request->getVar("title"),
						'order' => $this->request->getVar("order"),
					];

					$this->videoModel->update($id, $data);

					$response = [
						'status'   => 201,
						'success'    => 201,
						'messages' => [
							'success' => 'Video berhasil diperbarui'
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
					'messages' => 'Data Video tidak ditemukan',
				];
			}
			return $this->respondCreated($response);
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
			if ($data['role'] == 'member') {
				return $this->fail('Tidak dapat di akses oleh member', 400);
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
			return $this->respondDeleted($response);
		} catch (\Throwable $th) {
			return $this->fail($th->getMessage());
		}
		return $this->failNotFound('Data Video tidak ditemukan');
	}

	public function order()
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
				return $this->fail('Tidak dapat di akses selain admin & author', 400);
			}

			$orderReq = $this->request->getVar();

			for ($i = 0; $i < count($orderReq); $i++) {
				$video = $this->videoModel->find($orderReq[$i]->video_id);
				if ($video) {
					$data = [
						'order' => $orderReq[$i]->order
					];
					$this->videoModel->update($orderReq[$i]->video_id, $data);

					$response = [
						'status'   => 200,
						'success'    => 200,
						'messages' => [
							'success' => 'Video berhasil diupdate'
						]
					];
				} else {
					return $this->failNotFound('Data Video tidak ditemukan');
				}
			}

			return $this->respond($response);
		} catch (\Throwable $th) {
			return $this->fail($th->getMessage());
		}
	}
}
