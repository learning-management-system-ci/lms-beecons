<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Course;
use CodeIgniter\HTTP\RequestInterface;

class CourseController extends ResourceController
{

    public function index()
    {
        $model = new Course();
        $data = $model->orderBy('course_id', 'DESC')->findAll();

        if(count($data) > 0){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada data');
        }
    }

    public function show($id = null)
    {
        $model = new Course();

        if($model->find($id)){
            $data = $model->where('course_id', $id)->first();
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada data');
        }
    }

    public function create()
    {
        $model = new Course();

        $rules = [
            'title' => 'required|min_length[8]',
            'description' => 'required|min_length[8]',
            'price' => 'required|numeric',
            'thumbnail' => 'required',
            'is_access' => 'required|less_than_equal_to[1]'
        ];

        $messages = [
            "title" => [
                "required" => "{field}  tidak boleh kosong",
                'min_length' => '{field} minimal 8 karakter'
            ],
            "description" => [
                "required" => "{field}  tidak boleh kosong",
                'min_length' => '{field} minimal 8 karakter'
            ],
            "price" => [
                "required" => "{field}  tidak boleh kosong",
                "numeric" => "{field} harus berisi nomor",
            ],
            "thumbnail" => [
                "required" => "{field}  tidak boleh kosong"
            ],
            "is_access" => [
                "required" => "{field}  tidak boleh kosong",
                "less_than_equal_to" => "{field} harus berisi 0 (tidak aktif) atau 1 (aktif)"
            ],
        ];

         //$isAccess = $this->request->getVar('is_access');
        // $boolDecode = json_decode($isAccess);
         //return $isAccess;
        $response;
        if($this->validate($rules, $messages)) {
            $data = [
              'title' => $this->request->getVar('title'),
              'description' => $this->request->getVar('description'),
              'price' => $this->request->getVar('price'),
              'thumbnail' => $this->request->getVar('thumbnail'),
              'is_access' => $this->request->getVar('is_access'),
            ];

            $model->insert($data);
            $response = [
                'status'   => 201,
                'success'    => 201,
                'messages' => [
                    'success' => 'Course berhasil dibuat'
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

    public function update($id = null)
    {
        $model = new Course();

        $rules = [
            'title' => 'required|min_length[8]',
            'description' => 'required|min_length[8]',
            'price' => 'required|numeric',
            'thumbnail' => 'required',
            'is_access' => 'required|less_than_equal_to[1]'
        ];

        $messages = [
            "title" => [
                "required" => "{field}  tidak boleh kosong",
                'min_length' => '{field} minimal 8 karakter'
            ],
            "description" => [
                "required" => "{field}  tidak boleh kosong",
                'min_length' => '{field} minimal 8 karakter'
            ],
            "price" => [
                "required" => "{field}  tidak boleh kosong",
                "numeric" => "{field} harus berisi nomor",
            ],
            "thumbnail" => [
                "required" => "{field}  tidak boleh kosong"
            ],
            "is_access" => [
                "required" => "{field}  tidak boleh kosong",
                "less_than_equal_to" => "{field} harus berisi 0 (tidak aktif) atau 1 (aktif)"
            ],
        ];

        $response;
        if($model->find($id)){
            if($this->validate($rules, $messages)) {
                $data = [
                  'title' => $this->request->getRawInput('title'),
                  'description' => $this->request->getRawInput('description'),
                  'price' => $this->request->getRawInput('price'),
                  'thumbnail' => $this->request->getRawInput('thumbnail')
                ];

                $model->update($id, $data['title']);
                $response = [
                    'status'   => 201,
                    'success'    => 201,
                    'messages' => [
                        'success' => 'Course berhasil di perbarui'
                    ]
                ];
            }else{
                $response = [
                    'status'   => 400,
                    'error'    => 400,
                    'messages' => $this->validator->getErrors(),
                ];
            }
        }else{
            $response = [
                'status'   => 400,
                'error'    => 400,
                'messages' => 'Data tidak ditemukan',
            ];
        }


        return $this->respondCreated($response);
    }

    public function delete($id = null)
    {
        $model = new Course();

        if($model->find($id)){
            $model->delete($id);
            $response = [
                'status'   => 200,
                'success'    => 200,
                'messages' => [
                    'success' => 'Course berhasil di hapus'
                ]
            ];
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('Data tidak di temukan');
        }
    }

    public function latest($total = 4)
    {
        $model = new Course();

        $data = $model->limit($total)->orderBy('course_id', 'DESC')->find();
        return $this->respond($data);
    }

    public function find($key = null)
    {
        $model = new Course();
        $data = $model->orderBy('course_id', 'DESC')->like('title', $key)->find();

        if(count($data) > 0){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Data tidak ditemukan');
        }
    }
}
