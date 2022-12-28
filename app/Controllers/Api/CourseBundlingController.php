<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CourseBundling;
use App\Models\Course;
use App\Models\CourseTag;
use App\Models\CourseType;
use App\Models\Bundling;
use App\Models\Users;
use Firebase\JWT\JWT;

class CourseBundlingController extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->coursebundling = new CourseBundling();
        $this->course = new Course();
        $this->bundling = new Bundling();
    }

    public function index()
    {
        $modelCourseTag = new CourseTag();
        $modelCourseType = new CourseType();

        $data = $this->coursebundling->findAll();

        for ($i = 0; $i < count($data); $i++) {
            $bundling = $this->coursebundling
                ->where('course_bundling.course_bundling_id', $data[$i]['course_bundling_id'])
                ->join('bundling', 'course_bundling.bundling_id=bundling.bundling_id')
                ->join('users', 'bundling.author_id=users.id')
                ->select('bundling.*, users.fullname as author_fullname, users.company as author_company')
                ->findAll();

            $data[$i]['bundling'] = $bundling;

            for ($x = 0; $x < count($bundling); $x++) {
                $course = $this->coursebundling
                    ->where('course_bundling.bundling_id', $bundling[$x]['bundling_id'])
                    ->join('course', 'course_bundling.course_id=course.course_id')
                    ->join('users', 'course.author_id=users.id')
                    ->select('course.*, users.fullname as author_fullname, users.company as author_company')
                    ->findAll();

                $data[$i]['bundling'][$x]['course'] = $course;

                for ($a = 0; $a < count($course); $a++) {
                    $kategori = $this->course
                        ->where('course.course_id', $course[$a]['course_id'])
                        ->join('course_category', 'course.course_id=course_category.course_id')
                        ->join('category', 'course_category.course_category_id=category.category_id')
                        ->select('category.name as category_name')
                        ->findAll();

                    $data[$i]['bundling'][$x]['course'][$a]['category'] = $kategori;
                }

                for ($b = 0; $b < count($course); $b++) {
                    $tag = $modelCourseTag
                        ->select('name as tag_name')
                        ->where('course_id', $course[$b]['course_id'])
                        ->join('tag', 'tag.tag_id = course_tag.tag_id')
                        ->findAll();

                    $data[$i]['bundling'][$x]['course'][$b]['tag'] = $tag;
                }

                for ($c = 0; $c < count($course); $c++) {
                    $type = $modelCourseType
                        ->select('name as type_name')
                        ->where('course_id', $course[$c]['course_id'])
                        ->join('type', 'type.type_id = course_type.type_id')
                        ->findAll();

                    $data[$i]['bundling'][$x]['course'][$c]['type'] = $type;
                }
            }
        }
        return $this->respond($data);
    }

    public function show($id = null)
    {
        $data = $this->coursebundling->select('course_bundling_id, order, created_at, updated_at, deleted_at')->where('course_bundling_id', $id)->first();

        $bundling = $this->coursebundling
            ->where('course_bundling.course_bundling_id', $id)
            ->join('bundling', 'course_bundling.bundling_id=bundling.bundling_id')
            ->join('users', 'bundling.author_id=users.id')
            ->select('bundling.*, users.fullname as author_fullname, users.company as author_company')
            ->findAll();

        $data['bundling'] = $bundling;

        for ($x = 0; $x < count($bundling); $x++) {
            $course = $this->coursebundling
                ->where('course_bundling.bundling_id', $bundling[$x]['bundling_id'])
                ->join('course', 'course_bundling.course_id=course.course_id')
                ->join('users', 'course.author_id=users.id')
                ->select('course.*, users.fullname as author_fullname, users.company as author_company')
                ->findAll();

            $data['bundling'][$x]['course'] = $course;
        }

        if ($data != null) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data Course Bundling tidak ditemukan');
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
                'bundling_id' => 'required',
                'course_id' => 'required',
                'order' => 'required',
            ];

            $messages = [
                "bundling_id" => [
                    "required" => "{field} tidak boleh kosong",
                ],
                "course_id" => [
                    "required" => "{field} tidak boleh kosong",
                ],
                "order" => [
                    "required" => "{field} tidak boleh kosong",
                ],
            ];

            if ($this->validate($rules, $messages)) {
                $datacoursebundling = [
                    'bundling_id' => $this->request->getVar('bundling_id'),
                    'course_id' => $this->request->getVar('course_id'),
                    'order' => $this->request->getVar('order'),
                ];
                $this->coursebundling->insert($datacoursebundling);

                $response = [
                    'status'   => 201,
                    'success'    => 201,
                    'messages' => [
                        'success' => 'Course Bundling berhasil dibuat'
                    ]
                ];
            } else {
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

            $input = $this->request->getRawInput();

            $rules = [
                'bundling_id' => 'required',
                'course_id' => 'required',
                'order' => 'required',
            ];

            $messages = [
                "bundling_id" => [
                    "required" => "{field} tidak boleh kosong",
                ],
                "course_id" => [
                    "required" => "{field} tidak boleh kosong",
                ],
                "order" => [
                    "required" => "{field} tidak boleh kosong",
                ],
            ];

            $data = [
                "bundling_id" => $input["bundling_id"],
                "course_id" => $input["course_id"],
                "order" => $input["order"],
            ];

            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Course Bundling berhasil diperbarui'
                ]
            ];

            $cek = $this->coursebundling->where('course_bundling_id', $id)->findAll();

            if (!$cek) {
                return $this->failNotFound('Data Course Bundling tidak ditemukan');
            }

            if (!$this->validate($rules, $messages)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            if ($this->coursebundling->update($id, $data)) {
                return $this->respond($response);
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data Course Bundling tidak ditemukan');
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

            $data = $this->coursebundling->where('course_bundling_id', $id)->findAll();
            if ($data) {
                $this->coursebundling->delete($id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Course Bundling berhasil dihapus'
                    ]
                ];
                return $this->respondDeleted($response);
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data Course Bundling tidak ditemukan');
    }

    public function deletebybundling($id = null)
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

            $data = $this->coursebundling->where('bundling_id', $id)->findAll();
            if ($data) {
                // for ($i=0; $i < count($data); $i++) { 
                //     $this->coursebundling->delete('bundling_id', $data[$i]['bundling_id']);
                // }
                $this->coursebundling->where('bundling_id', $id)->delete();

                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Course Bundling berhasil dihapus'
                    ]
                ];
                return $this->respondDeleted($response);
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->failNotFound('Data Course Bundling tidak ditemukan');
    }

    public function createorder()
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
                $data = [
                    'bundling_id' => $orderReq[$i]->bundling_id,
                    'course_id' => $orderReq[$i]->course_id,
                    'order' => $orderReq[$i]->order
                ];
                if ($this->coursebundling->insert($data)) {
                    $response = [
                        'status'   => 200,
                        'success'    => 200,
                        'messages' => [
                            'success' => 'Course Bundling berhasil dibuat'
                        ]
                    ];
                } else {
                    return $this->failNotFound('Data Course Bundling tidak ditemukan');
                }
            }

            return $this->respond($response);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function updateorder()
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);
            $user = new Users;

            // cek role user
            $data = $user->where('id', $decoded->uid)->first();

            if ($data['role'] == 'member') {
                return $this->fail('Tidak dapat di akses selain admin & author', 400);
            }

            $orderReq = $this->request->getVar();

            $bundling = $this->bundling->where('bundling_id', $orderReq->bundling_id)->first();
            if (!$bundling) {
                return $this->fail('Bundling tidak ditemukan', 400);
            }

            // if ($data['id'] != $bundling['author_id']) {
            //     return $this->fail('Anda tidak mempunyai hak untuk mengubah bundling', 400);
            // }

            $this->coursebundling->where('bundling_id', $orderReq->bundling_id)->delete();

            for ($i = 0; $i < count($orderReq->order); $i++) {
                $data = [
                    'bundling_id' => $orderReq->bundling_id,
                    'course_id' => $orderReq->order[$i]->course_id,
                    'order' => $orderReq->order[$i]->order
                ];
                if ($this->coursebundling->insert($data)) {
                    $response = [
                        'status'   => 200,
                        'success'    => 200,
                        'messages' => [
                            'success' => 'Course Bundling berhasil diupdate'
                        ]
                    ];
                } else {
                    return $this->failNotFound('Gagal mengupdate');
                }
            }

            return $this->respond($response);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
