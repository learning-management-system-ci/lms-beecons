<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Video;
use CodeIgniter\HTTP\RequestInterface;

class CourseController extends ResourceController
{

    public function index()
    {
        $model = new Course();

        $data = $model
            ->select('course.*')
            ->join('course_category', 'course_category.course_id = course.course_id')
            ->join('category', 'category.category_id = course_category.category_id')
            ->orderBy('course.course_id', 'DESC')
            ->findAll();
        $category = $model
            ->select('category.*')
            ->join('course_category', 'course_category.course_id = course.course_id')
            ->join('category', 'category.category_id = course_category.category_id')
            ->orderBy('course.course_id', 'DESC')
            ->findAll();
        $type = $model
            ->select('type.*')
            ->join('course_type', 'course_type.course_id = course.course_id')
            ->join('type', 'type.type_id = course_type.type_id')
            ->orderBy('course.course_id', 'DESC')
            ->findAll();

        for($i = 0; $i < count($data); $i++){
            $tag = $model
                ->select('tag.*')
                ->join('course_tag', 'course_tag.course_id = course.course_id')
                ->join('tag', 'tag.tag_id = course_tag.tag_id')
                ->orderBy('course.course_id', 'DESC')
                ->where('course.course_id', $data[$i]['course_id'])
                ->findAll();
                
            $data[$i]['category'] = $category[$i];
            $data[$i]['type'] = $type[$i];

            for($k = 0; $k < count($tag); $k++){
                $data[$i]['tag'][$k] = $tag[$k];
            }
        }

        if(count($data) > 0){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada data');
        }
    }

    public function show($id = null)
    {
        $courseModel = new Course();
        $videoModel = new Video();

        if($courseModel->find($id)){
            $dataCourse = $courseModel->select('course_id as id, title, description, price, thumbnail')->where('course_id', $id)->first();
            $dataVideo = $videoModel->getData($id)->getResultArray();
            $video = [];
            foreach($dataVideo as $value) {
                $video[] = [
                    'vid_title' => $value['vid_title'],
                    'video' => $value['video'],
                    'order' => $value['order'],
                ];
            }
            $dataCourse['content'] = $video;
            $result = [
                'course' => $dataCourse,
            ];

        $data = $model
            ->select('course.*')
            ->join('course_category', 'course_category.course_id = course.course_id')
            ->join('category', 'category.category_id = course_category.category_id')
            ->orderBy('course.course_id', 'DESC')
            ->where('course.course_id', $id)
            ->findAll();
        $category = $model
            ->select('category.*')
            ->join('course_category', 'course_category.course_id = course.course_id')
            ->join('category', 'category.category_id = course_category.category_id')
            ->orderBy('course.course_id', 'DESC')
            ->where('course.course_id', $id)
            ->findAll();
        $type = $model
            ->select('type.*')
            ->join('course_type', 'course_type.course_id = course.course_id')
            ->join('type', 'type.type_id = course_type.type_id')
            ->orderBy('course.course_id', 'DESC')
            ->where('course.course_id', $id)
            ->findAll();
        $tag = $model
            ->select('tag.*')
            ->join('course_tag', 'course_tag.course_id = course.course_id')
            ->join('tag', 'tag.tag_id = course_tag.tag_id')
            ->orderBy('course.course_id', 'DESC')
            ->where('course.course_id', $id)
            ->findAll();

        for($i = 0; $i < count($data); $i++){
            $data[$i]['category'] = $category[$i];
            $data[$i]['type'] = $type[$i];

            for($k = 0; $k < count($tag); $k++){
                $data[$i]['tag'][$k] = $tag[$k];
            }
        }

        if($model->find($id)){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada data');
        }
    }


    public function create()
    {
        $modelCourse = new Course();
        $modelCourseCategory = new CourseCategory();

        $rules = [
            'title' => 'required|min_length[8]',
            'description' => 'required|min_length[8]',
            'price' => 'required|numeric',
            'thumbnail' => 'required',
            'category_id' => 'required|numeric'
        ];

        $messages = [
            "title" => [
                "required" => "{field} tidak boleh kosong",
                'min_length' => '{field} minimal 8 karakter'
            ],
            "description" => [
                "required" => "{field} tidak boleh kosong",
                'min_length' => '{field} minimal 8 karakter'
            ],
            "price" => [
                "required" => "field} tidak boleh kosong",
                "numeric" => "{field} harus berisi nomor",
            ],
            "thumbnail" => [
                "required" => "{field} tidak boleh kosong"
            ],
            "category_id" => [
                "required" => "{field} tidak boleh kosong"
            ],
        ];

        $response;
        if($this->validate($rules, $messages)) {
            $dataCourse = [
              'title' => $this->request->getVar('title'),
              'description' => $this->request->getVar('description'),
              'price' => $this->request->getVar('price'),
              'thumbnail' => $this->request->getVar('thumbnail'),
            ];
            $modelCourse->insert($dataCourse);

            $dataCourseCategory = [
                'course_id' => $modelCourse->insertID(),
                'category_id' => $this->request->getVar('category_id')
            ];
            $modelCourseCategory->insert($dataCourseCategory);

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
        $modelCourse = new Course();
        $modelCourseCategory = new CourseCategory();

        $rules = [
            'title' => 'required|min_length[8]',
            'description' => 'required|min_length[8]',
            'price' => 'required|numeric',
            'thumbnail' => 'required',
            'category_id' => 'required|numeric'
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
            "category_id" => [
                "required" => "{field} tidak boleh kosong"
            ],
        ];

        $response;
        if($modelCourse->find($id)){
            if($this->validate($rules, $messages)) {
                $dataCourse = [
                  'title' => $this->request->getRawInput('title'),
                  'description' => $this->request->getRawInput('description'),
                  'price' => $this->request->getRawInput('price'),
                  'thumbnail' => $this->request->getRawInput('thumbnail')
                ];
                $modelCourse->update($id, $dataCourse['title']);

                $dataCourseCategory = [
                    'course_id' => $id,
                    'category_id' => $this->request->getRawInput('category_id')['category_id']
                ];
                $courseCategoryID = $modelCourseCategory->where('course_id', $id)->find();
                $modelCourseCategory->where('course_id', $id)->update($courseCategoryID[0]['course_category_id'],$dataCourseCategory);

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
        $modelCourse = new Course();
        $modelCourseCategory = new CourseCategory();

        if($modelCourse->find($id)){
            $modelCourseCategory->where('course_id', $id)->delete();
            $modelCourse->delete($id);
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

        $data = $model
            ->select('course.*')
            ->join('course_category', 'course_category.course_id = course.course_id')
            ->join('category', 'category.category_id = course_category.category_id')
            ->orderBy('course.course_id', 'DESC')
            ->limit($total)
            ->find();
        $category = $model
            ->select('category.*')
            ->join('course_category', 'course_category.course_id = course.course_id')
            ->join('category', 'category.category_id = course_category.category_id')
            ->orderBy('course.course_id', 'DESC')
            ->limit($total)
            ->find();
        $type = $model
            ->select('type.*')
            ->join('course_type', 'course_type.course_id = course.course_id')
            ->join('type', 'type.type_id = course_type.type_id')
            ->orderBy('course.course_id', 'DESC')
            ->limit($total)
            ->find();

        for($i = 0; $i < count($data); $i++){
            $tag = $model
                ->select('tag.*')
                ->join('course_tag', 'course_tag.course_id = course.course_id')
                ->join('tag', 'tag.tag_id = course_tag.tag_id')
                ->orderBy('course.course_id', 'DESC')
                ->where('course.course_id', $data[$i]['course_id'])
                ->find();
                
            $data[$i]['category'] = $category[$i];
            $data[$i]['type'] = $type[$i];

            for($k = 0; $k < count($tag); $k++){
                $data[$i]['tag'][$k] = $tag[$k];
            }
        }

        // $data = $model->limit($total)->orderBy('course_id', 'DESC')->find();
        return $this->respond($data);
    }

    public function find($key = null)
    {
        $model = new Course();

        $data = $model
            ->select('course.*')
            ->join('course_category', 'course_category.course_id = course.course_id')
            ->join('category', 'category.category_id = course_category.category_id')
            ->orderBy('course.course_id', 'DESC')
            ->like('title', $key)
            ->findAll();
        $category = $model
            ->select('category.*')
            ->join('course_category', 'course_category.course_id = course.course_id')
            ->join('category', 'category.category_id = course_category.category_id')
            ->orderBy('course.course_id', 'DESC')
            ->like('title', $key)
            ->findAll();
        $type = $model
            ->select('type.*')
            ->join('course_type', 'course_type.course_id = course.course_id')
            ->join('type', 'type.type_id = course_type.type_id')
            ->orderBy('course.course_id', 'DESC')
            ->like('title', $key)
            ->findAll();

        for($i = 0; $i < count($data); $i++){
            $tag = $model
                ->select('tag.*')
                ->join('course_tag', 'course_tag.course_id = course.course_id')
                ->join('tag', 'tag.tag_id = course_tag.tag_id')
                ->orderBy('course.course_id', 'DESC')
                ->where('course.course_id', $data[$i]['course_id'])
                ->find();
                
            $data[$i]['category'] = $category[$i];
            $data[$i]['type'] = $type[$i];

            for($k = 0; $k < count($tag); $k++){
                $data[$i]['tag'][$k] = $tag[$k];
            }
        }

        if(count($data) > 0){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Data tidak ditemukan');
        }
    }
}
