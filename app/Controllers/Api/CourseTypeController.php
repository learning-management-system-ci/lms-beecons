<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CourseType;
use CodeIgniter\HTTP\RequestInterface;


class CourseTypeController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $model = new CourseType();
        $data = $model
            ->select('course_type.course_type_id')
            ->join('course', 'course.course_id = course_type.course_id')
            ->join('type', 'type.type_id = course_type.type_id')
            ->orderBy('course_type_id', 'DESC')
            ->findAll();
        $course = $model
            ->select('course.*')
            ->join('course', 'course.course_id = course_type.course_id')
            ->join('type', 'type.type_id = course_type.type_id')
            ->orderBy('course_type_id', 'DESC')
            ->findAll();
        $type = $model
            ->select('type.*')
            ->join('course', 'course.course_id = course_type.course_id')
            ->join('type', 'type.type_id = course_type.type_id')
            ->orderBy('course_type_id', 'DESC')
            ->findAll();

        for($i = 0; $i < count($data); $i++){
            $data[$i]['course'] = $course[$i];
            $data[$i]['type'] = $type[$i];
        }

        if(count($data) > 0){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada data');
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
        $key_ = ['course', 'type'];

        if(!in_array($key, $key_)){
            return $this->failValidationError('Key harus course atau type');
        } 

        $model = new CourseType();
        $key = $key.'.'.$key.'_id';

        $data = $model
            ->select('course_type.course_type_id')
            ->join('course', 'course.course_id = course_type.course_id')
            ->join('type', 'type.type_id = course_type.type_id')
            ->orderBy('course_type_id', 'DESC')
            ->where($key, $id)
            ->findAll();
        $course = $model
            ->select('course.*')
            ->join('course', 'course.course_id = course_type.course_id')
            ->join('type', 'type.type_id = course_type.type_id')
            ->orderBy('course_type_id', 'DESC')
            ->where($key, $id)
            ->findAll();
        $type = $model
            ->select('type.*')
            ->join('course', 'course.course_id = course_type.course_id')
            ->join('type', 'type.type_id = course_type.type_id')
            ->orderBy('course_type_id', 'DESC')
            ->where($key, $id)
            ->findAll();

        for($i = 0; $i < count($data); $i++){
            $data[$i]['course'] = $course[$i];
            $data[$i]['type'] = $type[$i];
        }

        if(count($data) > 0){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada data');
        }
    }
}
