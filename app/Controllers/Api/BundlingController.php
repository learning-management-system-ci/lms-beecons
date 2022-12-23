<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Bundling;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseBundling;
use App\Models\Video;
use App\Models\VideoCategory;
use App\Models\Users;
use App\Models\Cart;
use Firebase\JWT\JWT;

class BundlingController extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->bundling = new Bundling();
        $this->pathbundling = site_url() . 'upload/bundling/';
        $this->pathcourse = site_url() . 'upload/course/thumbnail/';
    }

    public function index()
    {
        $modelBundling = new Bundling();

        $bundling = $this->bundling
            ->select('bundling.*, category_bundling.name as category_name')
            ->join('category_bundling', 'bundling.category_bundling_id = category_bundling.category_bundling_id')
            ->findAll();

        for ($i = 0; $i < count($bundling); $i++) {
            $bundling[$i]['thumbnail'] = $this->pathbundling . $bundling[$i]['thumbnail'];
        }

        $data['bundling'] = $bundling;

        for ($x = 0; $x < count($bundling); $x++) {
            $course = $modelBundling
                ->where('bundling.bundling_id', $bundling[$x]['bundling_id'])
                ->join('course_bundling', 'bundling.bundling_id=course_bundling.bundling_id')
                ->join('course', 'course_bundling.course_id=course.course_id')
                ->select('course.*')
                ->findAll();
            
            for ($i = 0; $i < count($course); $i++) {
                $course[$i]['thumbnail'] = $this->pathcourse . $bundling[$i]['thumbnail'];
            }

            $data['bundling'][$x]['course'] = $course;

        }

        if (count($data) > 0) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Tidak ada data');
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
            if ($data['role'] == 'member' || $data['role'] == 'mentor') {
                return $this->fail('Tidak dapat di akses selain admin, partner & author', 400);
            }

            $rules = [
                "category_bundling_id" => "required",
                "title" => "required",
                "description" => "required|max_length[255]",
                "old_price" => "required|numeric",
                "new_price" => "required|numeric",
                'thumbnail' => 'uploaded[thumbnail]'
                    . '|is_image[thumbnail]'
                    . '|mime_in[thumbnail,image/jpg,image/jpeg,image/png,image/webp]'
                    . '|max_size[thumbnail,4000]'
            ];

            $messages = [
                "category_bundling_id" => [
                    "required" => "{field} tidak boleh kosong"
                ],
                "title" => [
                    "required" => "{field} tidak boleh kosong"
                ],
                "description" => [
                    "required" => "{field} tidak boleh kosong",
                    "max_length" => "{field} maksimal 255 karakter",
                ],
                "new_price" => [
                    "required" => "{field} tidak boleh kosong",
                    "numeric" => "{field} harus berisi angka"
                ],
                "old_price" => [
                    "required" => "{field} tidak boleh kosong",
                    "numeric" => "{field} harus berisi angka"
                ],
                "thumbnail" => [
                    'uploaded' => '{field} tidak boleh kosong',
                    'mime_in' => 'File Extention Harus Berupa png, jpg, atau jpeg',
                    'max_size' => 'Ukuran File Maksimal 4 MB'
                ],
            ];

            if (!$this->validate($rules, $messages)) {
                $response = [
                    'status' => 500,
                    'error' => true,
                    'message' => $this->validator->getErrors(),
                    'data' => []
                ];
            } else {
                $dataThumbnail = $this->request->getFile('thumbnail');
                $fileName = $dataThumbnail->getRandomName();
                
                $data = [
                    'category_bundling_id' => $this->request->getVar("category_bundling_id"),
                    'title' => $this->request->getVar("title"),
                    'description' => $this->request->getVar("description"),
                    'new_price' => $this->request->getVar("new_price"),
                    'old_price' => $this->request->getVar("old_price"),
                    'author_id' => $decoded->uid,
                    'thumbnail' => $fileName,
                ];

                $dataThumbnail->move('upload/bundling/', $fileName);
                $this->bundling->save($data);

                $response = [
                    'status' => 200,
                    'error' => false,
                    'message' => 'Bundling berhasil dibuat',
                    'data' => []
                ];
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->respondCreated($response);
    }

    public function show($id = null)
    {
        $modelBundling = new Bundling();
        $modelVideo = new Video();

        $path_bundling = site_url() . 'upload/bundling/';
        $path_course = site_url() . 'upload/course/thumbnail/';

        if ($modelBundling->find($id)) {
            // $data['bundling'] = $modelBundling->where('bundling_id', $id)->first();

            $data = $modelBundling->where('bundling_id', $id)->first();
            
            if ($data) {
                $data['thumbnail'] = $path_bundling . $data['thumbnail'];
            }

            $course_bundling = $modelBundling
                ->where('bundling.bundling_id', $id)
                ->join('course_bundling', 'bundling.bundling_id=course_bundling.bundling_id')
                ->select('course_bundling.*')
                ->orderBy('bundling.bundling_id', 'DESC')
                ->first();

            $video2 = $modelBundling
                ->where('bundling.bundling_id', $id)
                ->join('course_bundling', 'bundling.bundling_id=course_bundling.bundling_id')
                ->join('course', 'course_bundling.course_id=course.course_id')
                ->join('course_category', 'course.course_id=course_category.course_id')
                ->join('video_category', 'course_category.course_id=video_category.course_id')
                ->join('video', 'video_category.video_category_id=video.video_category_id')
                ->select('video_category.*, video.*')
                ->orderBy('bundling.bundling_id', 'DESC')
                ->first();

            $course = $modelBundling
                ->where('bundling.bundling_id', $id)
                ->join('course_bundling', 'bundling.bundling_id=course_bundling.bundling_id')
                ->join('course', 'course_bundling.course_id=course.course_id')
                ->join('course_category', 'course.course_id=course_category.course_id')
                ->join('video_category', 'course.course_id=video_category.course_id')
                ->select('course.*, course_category.*, video_category.video_category_id')
                ->orderBy('bundling.bundling_id', 'DESC')
                ->findAll();

            for ($i = 0; $i < count($course); $i++) {
                $course[$i]['thumbnail'] = $path_course . $course[$i]['thumbnail'];
            }

            $data['course'] = $course;

            for ($l = 0; $l < count($course); $l++) {
                $video = $modelVideo
                    ->where('video_category_id', $course[$l]['video_category_id'])
                    ->orderBy('order', 'DESC')
                    ->findAll();

                $countvideo = $modelVideo
                    ->where('video_category_id', $course[$l]['video_category_id'])
                    ->orderBy('order', 'DESC')
                    ->countAllResults();

                $data['course'][$l]['total_video'] = "$countvideo";
                // $data['course'][$l]['video'] = $video;
            }
            return $this->respond($data);
            for ($l = 0; $l < count($course_bundling); $l++) {
                $course = $modelBundling
                    ->where('bundling.bundling_id', $id)
                    ->join('course_bundling', 'bundling.bundling_id=course_bundling.bundling_id')
                    ->join('course', 'course_bundling.course_id=course.course_id')
                    ->join('course_category', 'course.course_id=course_category.course_id')
                    ->select('course.*, course_category.*')
                    ->orderBy('bundling.bundling_id', 'DESC')
                    ->findAll();
            }

            return $this->respond($data);
        } else {
            return $this->failNotFound('Tidak ada data');
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
            if ($data['role'] == 'member' || $data['role'] == 'mentor') {
                return $this->fail('Tidak dapat di akses selain admin, partner & author', 400);
            }

            $rules_a = [
                "category_bundling_id" => "required",
                "title" => "required",
                "description" => "required|max_length[255]",
                "old_price" => "required|numeric",
                "new_price" => "required|numeric"
            ];

            $rules_b = [
                'thumbnail' => 'uploaded[thumbnail]'
                    . '|is_image[thumbnail]'
                    . '|mime_in[thumbnail,image/jpg,image/jpeg,image/png,image/webp]'
                    . '|max_size[thumbnail,4000]'
            ];

            $messages_a = [
                "category_bundling_id" => [
                    "required" => "{field} tidak boleh kosong"
                ],
                "title" => [
                    "required" => "{field} tidak boleh kosong"
                ],
                "description" => [
                    "required" => "{field} tidak boleh kosong",
                    "max_length" => "{field} maksimal 255 karakter",
                ],
                "new_price" => [
                    "required" => "{field} tidak boleh kosong",
                    "numeric" => "{field} harus berisi angka"
                ],
                "old_price" => [
                    "required" => "{field} tidak boleh kosong",
                    "numeric" => "{field} harus berisi angka"
                ]
            ];

            $messages_b = [
                "thumbnail" => [
                    'uploaded' => '{field} tidak boleh kosong',
                    'mime_in' => 'File Extention Harus Berupa png, jpg, atau jpeg',
                    'max_size' => 'Ukuran File Maksimal 4 MB'
                ],
            ];

            $findBundling = $this->bundling->where('bundling_id', $id)->first();
            if ($findBundling) {
                if ($this->validate($rules_a, $messages_a)) {
                    if ($this->validate($rules_b, $messages_b)) {

                        $oldThumbnail = $findBundling['thumbnail'];
                        $dataThumbnail = $this->request->getFile('thumbnail');

                        if ($dataThumbnail->isValid() && !$dataThumbnail->hasMoved()) {
                            if (file_exists("upload/bundling/" . $oldThumbnail)) {
                                unlink("upload/bundling/" . $oldThumbnail);
                            }
                            $fileName = $dataThumbnail->getRandomName();
                            $dataThumbnail->move('upload/bundling/', $fileName);
                        } else {
                            $fileName = $oldThumbnail['thumbnail'];
                        }

                        $data = [
                            'category_bundling_id' => $this->request->getVar("category_bundling_id"),
                            'title' => $this->request->getVar("title"),
                            'description' => $this->request->getVar("description"),
                            'new_price' => $this->request->getVar("new_price"),
                            'old_price' => $this->request->getVar("old_price"),
                            'author_id' => $decoded->uid,
                            'thumbnail' => $fileName,
                        ];

                        $this->bundling->update($id, $data);

                        $response = [
                            'status'   => 201,
                            'success'    => 201,
                            'messages' => [
                                'success' => 'Bundling berhasil diubah'
                            ]
                        ];
                    }

                    $data = [
                        'category_bundling_id' => $this->request->getVar("category_bundling_id"),
                        'title' => $this->request->getVar("title"),
                        'description' => $this->request->getVar("description"),
                        'new_price' => $this->request->getVar("new_price"),
                        'old_price' => $this->request->getVar("old_price"),
                        'author_id' => $this->request->getVar("author_id")
                    ];

                    $this->bundling->update($id, $data);

                    $response = [
                        'status'   => 201,
                        'success'    => 201,
                        'messages' => [
                            'success' => 'Bundling berhasil diubah'
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
                    'messages' => 'Data tidak ditemukan',
                ];
            }

            return $this->respondCreated($response);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data Bundling tidak ditemukan');
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
            $modelCourseBundling = new CourseBundling;
            $modelCart = new Cart;

            // cek role user
            $data = $user->select('role')->where('id', $decoded->uid)->first();
            if ($data['role'] == 'member' || $data['role'] == 'mentor') {
                return $this->fail('Tidak dapat di akses selain admin, partner & author', 400);
            }

            $data = $this->bundling->where('bundling_id', $id)->findAll();
            if ($data) {
                $modelCourseBundling->where('bundling_id', $id)->delete();
                $modelCart->where('bundling_id', $id)->delete();
                $this->bundling->delete($id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Bundling berhasil dihapus'
                    ]
                ];
                return $this->respondDeleted($response);
            } else {
                return $this->failNotFound('Data bundling tidak ditemukan');
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data bundling tidak ditemukan');
    }
}
