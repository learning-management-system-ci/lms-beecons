<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ContactUs;
use App\Models\Users;
use Firebase\JWT\JWT;

class ContactUsController extends ResourceController
{
    function __construct(){
		$this->contactus = new ContactUs();
	}

    public function index()
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

            $data = $this->contactus->orderBy('contact_us_id', 'DESC')->findAll();
            if ($data) {
                return $this->respond($data);
            } else {
                return $this->failNotFound('Data Pertanyaan tidak ditemukan');
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function show($id = null){
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

            $data = $this->contactus->where('contact_us_id', $id)->first();
            if($data){
                return $this->respond($data);
            }else{
                return $this->failNotFound('Data Pertanyaan tidak ditemukan');
            }
	    } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function answer() {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
		    $decoded = JWT::decode($token, $key, ['HS256']);
            $user = new Users;

            // cek role user
            $data = $user->select('role')->where('id', $decoded->uid)->first();
            if ($data['role'] == 'member' || $data['role'] == 'mentor' || $data['role'] == 'partner') {
                return $this->fail('Tidak dapat di akses selain admin & author', 400);
            }

            $rules = [
                "email" => "required",
                "answer" => "required",
            ];
    
            $messages = [
                "email" => [
                    "required" => "{field} tidak boleh kosong"
                ],
                "answer" => [
                    "required" => "{field} tidak boleh kosong"
                ],
            ];
    
            if($this->validate($rules, $messages)) {
                $data = [
                    'email' => $this->request->getVar('email'),
                    'answer' => $this->request->getVar('answer'),
                ];
                
                $email = \Config\Services::email();
                $email->setTo($data['email']);
                $email->setFrom('hendrikusozzie@gmail.com');
              
                $email->setSubject('Jawaban Dari Pertanyaan ' . $data['email']);
                $email->setMessage($data['answer']);
    
                if ($email->send()){
                    $response = [
                        'status'   => 201,
                        'messages' => [
                            'success' => 'Jawaban berhasil dikirim'
                        ]
                    ];
                } else {
                    $response = [
                        'status'   => 400,
                        'messages' => [
                            'error' => 'Jawaban gagal dikirim'
                        ]
                    ];
                }
            }else{
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

    public function question()
	{
		$rules = [
			"email" => "required|valid_email",
			"question" => "required|max_lenght[2500]",
            "question_image" => 'uploaded[question_image]'
                . '|is_image[question_image]'
                . '|mime_in[question_image,image/jpg,image/jpeg,image/png,image/webp]'
                . '|max_size[question_image,4000]',
		];

		$messages = [
			"email" => [
				"required" => "{field} tidak boleh kosong",
                'valid_email' => 'Format {field} tidak sesuai'
			],
			"question" => [
				"required" => "{field} tidak boleh kosong",
                "max_length" => "{field} maksimal 2500 karakter",
			],
			"question_image" => [
				'uploaded' => '{field} tidak boleh kosong',
				'is_image' => '{field} hanya dapat diisi dengan image',
                'mime_in' => 'File image Harus Berupa png, jpg, atau jpeg',
                'max_size' => 'Ukuran file maksimal 2 MB'
			],
		];

		if($this->validate($rules, $messages)) {
            $dataquestion_image = $this->request->getFile('question_image');
            if (is_null($dataquestion_image)) {
                $fileName = null;
            } else {
                $fileName = $dataquestion_image->getRandomName();
            }

			$data = [
				'email' => $this->request->getVar('email'),
				'question' => $this->request->getVar('question'),
				'question_image' => $fileName,
			];

            if ($fileName != null) {
                $dataquestion_image->move('upload/question/', $fileName);
            }
			
			$email = \Config\Services::email();
			$email->setTo('hendrikusozzie@gmail.com');
			$email->setFrom($data['email']);
		  
			$email->setSubject('Pertanyaan Dari ' . $data['email']);
			$email->setMessage($data['question']);
            $email->attach('upload/question/' . $fileName);

			if ($email->send() && $this->contactus->insert($data)){
				$response = [
					'status'   => 201,
					'messages' => [
						'success' => 'Pertanyaan berhasil dikirim'
					]
				];
			} else {
				$response = [
					'status'   => 400,
					'messages' => [
						'error' => 'Pertanyaan gagal dikirim'
					]
				];
			}
		}else{
			$response = [
				'status'   => 400,
				'error'    => 400,
				'messages' => $this->validator->getErrors(),
			];
		}

		return $this->respondCreated($response); 
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
            if ($data['role'] == 'member' || $data['role'] == 'mentor' || $data['role'] == 'partner') {
                return $this->fail('Tidak dapat di akses selain admin & author', 400);
            }

            $data = $this->contactus->where('contact_us_id', $id)->findAll();
            if($data){
                $this->contactus->delete($id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Data Pertanyaan berhasil dihapus'
                    ]
                ];
            }
            return $this->respondDeleted($response);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data Pertanyaan tidak ditemukan');
    }
}
