<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CourseCategory;
use CodeIgniter\HTTP\RequestInterface;
use Firebase\JWT\JWT;

class CourseCategoryController extends ResourceController
{

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Akses token diperlukan');
        $token = explode(' ', $header)[1];

        try {
		    $decoded = JWT::decode($token, $key, ['HS256']);
            $model = new CourseCategory();
            $data = $model
                ->select('category.category_id')
                ->join('course', 'course.course_id = course_category.course_id')
                ->join('category', 'category.category_id = course_category.category_id')
                ->orderBy('course_category_id', 'DESC')
                ->findAll();
            $course = $model
                ->select('course.*')
                ->join('course', 'course.course_id = course_category.course_id')
                ->join('category', 'category.category_id = course_category.category_id')
                ->orderBy('course_category_id', 'DESC')
                ->findAll();
            $category = $model
                ->select('category.*')
                ->join('course', 'course.course_id = course_category.course_id')
                ->join('category', 'category.category_id = course_category.category_id')
                ->orderBy('course_category_id', 'DESC')
                ->findAll();
    
            for($i = 0; $i < count($data); $i++){
                $data[$i]['course'] = $course[$i];
                $data[$i]['category'] = $category[$i];
            }
    
            if(count($data) > 0){
                return $this->respond($data);
            }else{
                return $this->failNotFound('Tidak ada data');
            }
	    } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }

    public function filter($key = null, $id = null)
    {
        $key_ = ['course', 'category'];

        if(!in_array($key, $key_)){
            return $this->failValidationError('Key harus course atau category');
        } 

        $model = new CourseCategory();
        $key = $key.'.'.$key.'_id';

        $data = $model
            ->select('category.category_id')
            ->join('course', 'course.course_id = course_category.course_id')
            ->join('category', 'category.category_id = course_category.category_id')
            ->orderBy('course_category_id', 'DESC')
            ->where($key, $id)
            ->findAll();
        $course = $model
            ->join('course', 'course.course_id = course_category.course_id')
            ->join('category', 'category.category_id = course_category.category_id')
            ->orderBy('course_category_id', 'DESC')
            ->where($key, $id)
            ->findAll();
        $category = $model
            ->select('category.*')
            ->join('course', 'course.course_id = course_category.course_id')
            ->join('category', 'category.category_id = course_category.category_id')
            ->orderBy('course_category_id', 'DESC')
            ->where($key, $id)
            ->findAll();
        for($i = 0; $i < count($data); $i++){
            $data[$i]['course'] = $course[$i];
            $data[$i]['category'] = $category[$i];
        }
        
        if(count($data) > 0){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada data');
        }
    }
}
