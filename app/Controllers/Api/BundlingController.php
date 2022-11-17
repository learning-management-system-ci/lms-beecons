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
    }

    public function index()
    {
        $data = $this->bundling
            ->select('bundling.*, category_bundling.name as category_name')
            ->orderBy('bundling_id', 'DESC')
            ->join('category_bundling', 'bundling.category_bundling_id = category_bundling.category_bundling_id')
            ->findAll();

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
            ];

            if (!$this->validate($rules, $messages)) {
                $response = [
                    'status' => 500,
                    'error' => true,
                    'message' => $this->validator->getErrors(),
                    'data' => []
                ];
            } else {
                $data['category_bundling_id'] = $this->request->getVar("category_bundling_id");
                $data['title'] = $this->request->getVar("title");
                $data['description'] = $this->request->getVar("description");
                $data['new_price'] = $this->request->getVar("new_price");
                $data['old_price'] = $this->request->getVar("old_price");

                $this->bundling->insert($data);

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

    // public function show($id = null){
    //     // $data = $this->bundling->where('bundling_id', $id)->first();
    //     // if($data){
    //     //     return $this->respond($data);
    //     // }else{
    //     //     return $this->failNotFound('Data bundling tidak ditemukan');
    //     // }
    //     $data = $this->bundling->where('bundling_id', $id)->getShow($id);
    //     $dataBundling = [];
    //     foreach($data as $value) {
    //         $dataBundling[] = [
    //             'bundling_id' => $value['bundling_id'],
    //             'category_bundling_id' => $this->bundling->getData($id),
    //             'title' => $value['title'],
    //             'description' => $value['description'],
    //             'old_price' => $value['old_price'],
    //             'new_price' => $value['new_price'],
    //             'created_at' => $value['created_at'],
    //             'updated_at' => $value['updated_at'],
    //         ];
    //     }
    //     if($dataBundling){
    //         return $this->respond($dataBundling);
    //     }else{
    //         return $this->failNotFound('Data Bundling tidak ditemukan');
    //     }
    // }

    public function show($id = null)
    {
        $modelBundling = new Bundling();
        $modelVideo = new Video();

        $path = site_url() . 'upload/course/thumbnail/';

        if ($modelBundling->find($id)) {
            $data['bundling'] = $modelBundling->where('bundling_id', $id)->first();

            // $bundling = $modelBundling
            //     ->where('bundling.bundling_id', $id)
            //     ->join('course_bundling', 'bundling.bundling_id=course_bundling.bundling_id')
            //     ->join('course', 'course_bundling.course_id=course.course_id')
            //     ->join('course_category', 'course.course_id=course_category.course_id')
            //     ->join('video_category', 'course_category.course_id=video_category.course_id')
            //     ->join('video', 'video_category.video_category_id=video.video_category_id')
            //     ->select('*')
            //     ->orderBy('bundling.bundling_id', 'DESC')
            //     ->first();

            $course_bundling = $modelBundling
                ->where('bundling.bundling_id', $id)
                ->join('course_bundling', 'bundling.bundling_id=course_bundling.bundling_id')
                ->select('course_bundling.*')
                ->orderBy('bundling.bundling_id', 'DESC')
                ->first();

            // $course = $modelBundling
            //     ->where('bundling.bundling_id', $id)
            //     ->join('course_bundling', 'bundling.bundling_id=course_bundling.bundling_id')
            //     ->join('course', 'course_bundling.course_id=course.course_id')
            //     ->join('course_category', 'course.course_id=course_category.course_id')
            //     ->select('course.*, course_category.*')
            //     ->orderBy('bundling.bundling_id', 'DESC')
            //     ->first();

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

            // $videoCategory = $modelBundling
            //     ->where('bundling.bundling_id', $id)
            //     ->join('course_bundling', 'bundling.bundling_id=course_bundling.bundling_id')
            //     ->join('course', 'course_bundling.course_id=course.course_id')
            //     ->join('course_category', 'course.course_id=course_category.course_id')
            //     ->join('video_category', 'course_category.course_id=video_category.course_id')
            //     ->orderBy('video_category.video_category_id', 'DESC')
            //     ->findAll();

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
                $course[$i]['thumbnail'] = $path . $course[$i]['thumbnail'];
            }

            $data['course'] = $course;

            // for ($i = 0; $i < count($course); $i++) {
            //     $course[$i]['thumbnail'] = $path . $course[$i]['thumbnail'];
            // }

            for ($l = 0; $l < count($course); $l++) {
                // $course[$l]['thumbnail'] = $path . $course[$l]['thumbnail'];
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

                // $videoCategory = $modelBundling
                //     ->where('bundling.bundling_id', $id)
                //     ->join('course_bundling', 'bundling.bundling_id=course_bundling.bundling_id')
                //     ->join('course', 'course_bundling.course_id=course.course_id')
                //     ->join('course_category', 'course.course_id=course_category.course_id')
                //     ->join('video_category', 'course_category.course_id=video_category.course_id')
                //     ->select('video_category.*')
                //     ->orderBy('video_category.video_category_id', 'DESC')
                //     ->findAll();

                // $data['course'] = $course;
                // $data[$l]['video'] = $videoCategory;
                // $data['video_category'] = $videoCategory;
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

            $input = $this->request->getRawInput();

            $rules = [
                "category_bundling_id" => "required",
                "title" => "required",
                "description" => "required|max_length[255]",
                "new_price" => "required|numeric",
                "old_price" => "required|numeric",
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
                "old_price" => [
                    "required" => "{field} tidak boleh kosong",
                    "numeric" => "{field} harus berisi angka"
                ],
                "new_price" => [
                    "required" => "{field} tidak boleh kosong",
                    "numeric" => "{field} harus berisi angka"
                ],
            ];

            $data = [
                "category_bundling_id" => $input["category_bundling_id"],
                "title" => $input["title"],
                "description" => $input["description"],
                "new_price" => $input["new_price"],
                "old_price" => $input["old_price"],
            ];

            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Bundling berhasil diperbarui'
                ]
            ];

            $cek = $this->bundling->where('bundling_id', $id)->findAll();
            if (!$cek) {
                return $this->failNotFound('Data bundling tidak ditemukan');
            }

            if (!$this->validate($rules, $messages)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            if ($this->bundling->update($id, $data)) {
                return $this->respond($response);
            }
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
