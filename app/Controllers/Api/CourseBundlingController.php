<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CourseBundling;

class CourseBundlingController extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->coursebundling = new CourseBundling();
    }

    public function index(){
        $data = $this->coursebundling->getCourseBundling();
        $dataCourseBundling = [];
        foreach($data as $value) {
            $dataCourseBundling[] = [
                'course_bundling_id' => $value['course_bundling_id'],
                'bundling' => $this->coursebundling->getDataBundling($data_bundling_id = $value['bundling_id']),
                'course' => $this->coursebundling->getDataCourse($data_course_id = $value['course_id']),
                'created_at' => $value['created_at'],
                'updated_at' => $value['updated_at'],
            ];
        }
        return $this->respond($dataCourseBundling);
    }

    public function show($id = null){
        $data = $this->coursebundling->where('course_bundling_id', $id)->getShow($id);
        $dataCourseBundling = [];
        foreach($data as $value) {
            $dataCourseBundling[] = [
                'course_bundling_id' => $value['course_bundling_id'],
                'bundling' => $this->coursebundling->getDataBundling($data_bundling_id = $value['bundling_id']),
                'course' => $this->coursebundling->getDataCourse($data_course_id = $value['course_id']),
                'created_at' => $value['created_at'],
                'updated_at' => $value['updated_at'],
            ];
        }
        if($dataCourseBundling){
            return $this->respond($dataCourseBundling);
        }else{
            return $this->failNotFound('Data Course Bundling tidak ditemukan');
        }
    }
}
