<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ContactUs;
use App\Models\Users;
use Firebase\JWT\JWT;

class ContactUsController extends ResourceController
{
    function __construct()
    {
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

            $data = $this->contactus->findAll();

            $path = site_url() . 'upload/users/';

            $response = [];
            
            for ($i = 0; $i < count($data); $i++) {
                array_push($response, [
                    "contact_us_id" => $data[$i]['contact_us_id'],
                    "email" =>  $data[$i]['email'],
                    "question" => $data[$i]['question'],
                    "question_image" => $path . $data[$i]['question_image'],
                    "created_at" => $data[$i]['created_at'],
                    "updated_at" => $data[$i]['updated_at'],
                ]);
            }
            if ($response) {
                return $this->respond($response);
            } else {
                return $this->failNotFound('Data Pertanyaan tidak ditemukan');
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function show($id = null)
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

            $data = $this->contactus->where('contact_us_id', $id)->first();

            $path = site_url() . 'upload/question/';

            $response = [
                "contact_us_id" => $data['contact_us_id'],
                "email" =>  $data['email'],
                "question" => $data['question'],
                "question_image" => $path . $data['question_image'],
                "created_at" => $data['created_at'],
                "updated_at" => $data['updated_at'],
            ];

            if($response){
                return $this->respond($response);
            }else{
                return $this->failNotFound('Data Pertanyaan tidak ditemukan');
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function answer()
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

            if ($this->validate($rules, $messages)) {
                $data = [
                    'email' => $this->request->getVar('email'),
                    'answer' => $this->request->getVar('answer'),
                ];

                $email = \Config\Services::email();
                $email->setTo($data['email']);
                $email->setFrom('hendrikusozzie@gmail.com');

                $email->setSubject('Jawaban Dari Pertanyaan ' . $data['email']);
                $email->setMessage($data['answer']);

                if ($email->send()) {
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

    public function question()
    {
        $rules_a = [
            "email" => "required|valid_email",
            "question" => "required|max_length[2500]"
        ];

        $rules_b = [
            "question_image" => 'uploaded[question_image]'
                . '|is_image[question_image]'
                . '|mime_in[question_image,image/jpg,image/jpeg,image/png,image/webp]'
                . '|max_size[question_image,4000]',
        ];

        $messages_a = [
            "email" => [
                "required" => "{field} tidak boleh kosong",
                'valid_email' => 'Format {field} tidak sesuai'
            ],
            "question" => [
                "required" => "{field} tidak boleh kosong",
                "max_length" => "{field} maksimal 2500 karakter",
            ]
        ];

        $messages_b = [
            "question_image" => [
                'uploaded' => '{field} tidak boleh kosong',
                'is_image' => '{field} hanya dapat diisi dengan image',
                'mime_in' => 'File image Harus Berupa png, jpg, atau jpeg',
                'max_size' => 'Ukuran file maksimal 2 MB'
            ]
        ];

        if ($this->validate($rules_a, $messages_a) == TRUE && $this->validate($rules_b, $messages_b) == FALSE) {
            $data = [
                'email' => $this->request->getVar('email'),
                'question' => $this->request->getVar('question'),
            ];

            $email = \Config\Services::email();
            $email->setTo('hendrikusozzie@gmail.com');
            $email->setFrom($data['email']);

            $email->setSubject('Pertanyaan Dari ' . $data['email']);
            $email->setMessage($data['question']);
            $email->send();
            
            $this->contactus->insert($data);

            $response = [
                'status'   => 201,
                'messages' => [
                    'success' => 'Pertanyaan berhasil dikirim'
                ]
            ];
        } elseif ($this->validate($rules_b, $messages_b) == TRUE && $this->validate($rules_a, $messages_a) == TRUE) {
            $dataquestion_image = $this->request->getFile('question_image');
            $fileName = $dataquestion_image->getRandomName();
            $data = [
                'email' => $this->request->getVar('email'),
                'question' => $this->request->getVar('question'),
                'question_image' => $fileName,
            ];
            $dataquestion_image->move('upload/question/', $fileName);

            $email = \Config\Services::email();
            $email->setTo('hendrikusozzie@gmail.com');
            $email->setFrom($data['email']);

            $email->setSubject('Pertanyaan Dari ' . $data['email']);
            $email->setMessage($data['question']);
            $email->attach('upload/question/' . $fileName);
            $email->send();
                
            $this->contactus->insert($data);

            $response = [
                'status'   => 201,
                'messages' => [
                    'success' => 'Pertanyaan berhasil dikirim'
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
            if ($data['role'] == 'member' || $data['role'] == 'mentor' || $data['role'] == 'partner') {
                return $this->fail('Tidak dapat di akses selain admin & author', 400);
            }

            $data = $this->contactus->where('contact_us_id', $id)->findAll();
            if ($data) {
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
