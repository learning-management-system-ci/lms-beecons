<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CourseTag;
use CodeIgniter\HTTP\RequestInterface;

class CourseTagController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $model = new CourseTag();
        $tag_by_course_id = [];
        
        $data = $model
            ->select('course_tag.course_tag_id')
            ->join('course', 'course.course_id = course_tag.course_id')
            ->join('tag', 'tag.tag_id = course_tag.tag_id')
            ->orderBy('course_tag_id', 'DESC')
            ->findAll();
        $course = $model
            ->select('course.*')
            ->join('course', 'course.course_id = course_tag.course_id')
            ->join('tag', 'tag.tag_id = course_tag.tag_id')
            ->orderBy('course_tag_id', 'DESC')
            ->findAll();
        $tag = $model
            ->select('tag.*')
            ->join('course', 'course.course_id = course_tag.course_id')
            ->join('tag', 'tag.tag_id = course_tag.tag_id')
            ->orderBy('course_tag_id', 'DESC')
            ->findAll();

        for($i = 0; $i < count($data); $i++){
            $data[$i]['course'] = $course[$i];
            $data[$i]['tag'] = $tag[$i];
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
        $key_ = ['course', 'tag'];
        $model = new CourseTag();
        $tag_by_course_id = [];
        $data = [];

        if(!in_array($key, $key_)){
            return $this->failValidationError('Key harus course atau tag');
        }

        if($key == 'course'){
            $course = $model
                ->select('course.*')
                ->join('course', 'course.course_id = course_tag.course_id')
                ->join('tag', 'tag.tag_id = course_tag.tag_id')
                ->orderBy('course_tag_id', 'DESC')
                ->where('course.course_id', $id)
                ->findAll();
            $tag = $model
                ->select('tag.*')
                ->join('course', 'course.course_id = course_tag.course_id')
                ->join('tag', 'tag.tag_id = course_tag.tag_id')
                ->orderBy('course_tag_id', 'DESC')
                ->where('course.course_id', $id)
                ->findAll();

            for($i = 0; $i < count($tag); $i++){
                $tag_by_course_id[$i] = $tag[$i];
            }

            $data['course'] = $course[0];
            $data['tag'] = $tag_by_course_id;
        }else{
            $key = $key.'.'.$key.'_id';

            $data = $model
                ->select('course_tag.course_tag_id')
                ->join('course', 'course.course_id = course_tag.course_id')
                ->join('tag', 'tag.tag_id = course_tag.tag_id')
                ->orderBy('course_tag_id', 'DESC')
                ->where($key, $id)
                ->findAll();
            $course = $model
                ->join('course', 'course.course_id = course_tag.course_id')
                ->join('tag', 'tag.tag_id = course_tag.tag_id')
                ->orderBy('course_tag_id', 'DESC')
                ->where($key, $id)
                ->findAll();
            $tag = $model
                ->select('tag.*')
                ->join('course', 'course.course_id = course_tag.course_id')
                ->join('tag', 'tag.tag_id = course_tag.tag_id')
                ->orderBy('course_tag_id', 'DESC')
                ->where($key, $id)
                ->findAll();
            
            for($i = 0; $i < count($data); $i++){
                $data[$i]['course'] = $course[$i];
                $data[$i]['tag'] = $tag[$i];
            }
        }

        if(count($data) > 0){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada data');
        }
    }
}
