<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CourseBundling;
use App\Models\Course;
use App\Models\Bundling;

class CourseBundlingController extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->coursebundling = new CourseBundling();
        $this->course = new Course();
        $this->bundling = new Bundling();
    }

    // public function index(){
    //     // $data['course_bundling'] = $this->coursebundling->orderBy('course_bundling_id', 'DESC')->findAll();
    //     // $data['course_bundling'] = $this->coursebundling->getCourse();
    //     // $data['course_bundling'] = $this->coursebundling->getBundling();
    //     $data = [
    //         'course' => $this->coursebundling->getData(),
    //         // 'bundling' => $this->bundling->getBundling(),
    //     ];
    //     // $this->coursebundling->select('course_bundling_id');
    //     // $this->coursebundling->where('course_id', $course_id);
    //     // $query = $this->coursebundling->get();
    //     // $course_bundling_id = SELECT userid FROM users WHERE username;
    //     // $data['course'] = $this->course->where('course_id', $course_bundling_id)->first();
    //     // $data['bundling'] = $this->bundling->where('bundling_id', $course_bundling_id)->first();
    //     // $query = $db->query('SELECT course_id FROM course_bundling');
    //     // $row = $query->getRow();
    //     return $this->respond($data);
    // }

    // public function index(){
    //     $data = [
    //         'coursebundling' => $this->coursebundling->orderBy('course_bundling_id', 'DESC')->findAll(),
    //         // 'course' => $this->coursebundling->getData(),
    //         // 'course' => $this->coursebundling->with('groups')getData(),
    //         // 'bundling' => $this->bundling->getBundling(),
    //     ];
    //     return $this->respond($data);
    // }

    // public function index(){
    //     // Get Data Bundling
    //     $get_bundling_id = $this->coursebundling->getBundlingId();
    //     $bundling_id = json_encode($get_bundling_id);
    //     $data_bundling_id = substr($bundling_id,16,-2);
        
    //     // Get Data Course
    //     $get_course_id = $this->coursebundling->getCourseId();
    //     $course_id = json_encode($get_course_id);
    //     $data_course_id = substr($course_id,14,-2);
        
    //     $data = [
    //         'coursebundling' => $this->coursebundling->getCourseBundling(),
    //         'bundling' => $this->coursebundling->getDataBundling($data_bundling_id),
    //         'course' => $this->coursebundling->getDataCourse($data_course_id),
    //         // ['course' => $this->coursebundling->getData()],
    //             // 'course' => $this->coursebundling->getCourse(),
    //             // 'course' => $this->coursebundling->getData(),
    //             // 'course' => $this->coursebundling->with('groups')getData(),
    //             // 'bundling' => $this->bundling->getBundling(),
    //         // $this->coursebundling->getDataBundling($bundling_id),
    //         // $bundling_id,
    //         // $data_bundling_id,
    //         // $course_id,
    //         // $data_course_id,
    //         // ],
    //         // 'coursebundling' => $this->coursebundling->orderBy('course_bundling_id', 'DESC')->findAll(),
    //         // 'course' => $this->coursebundling->getCourse(),
    //         // 'course' => $this->coursebundling->getData(),
    //         // 'course' => $this->coursebundling->with('groups')getData(),
    //         // 'bundling' => $this->bundling->getBundling(),
    //     ];
    //     return $this->respond($data);
    // }

    public function index(){
        // Get Data Course Bundling
        $get_course_bundling = $this->coursebundling->getCourseBundling();
        
        // Get Data Bundling
        $get_bundling_id = $this->coursebundling->getBundlingId();
        $databundlingid = [];
        foreach($get_bundling_id as $value) {
            $databundlingid[] = [
                'bundling_id' => $value['bundling_id']
            ];
        };

        $bundling_id = json_encode($databundlingid);
        $data_bundling_id = substr($bundling_id,16,-2);

        // foreach ($get_bundling_id as $row) {
        //     echo $row->bundling_id; // access attributes
        //     // echo $user->reverseName(); // or methods defined on the 'User' class
        // }
        // foreach ($get_bundling_id as $row)
        // {
        //     $data_bundling_id = $row->bundling_id;
        //     // $bundling_id = json_encode($data_bundling_id);
        //     // $data_bundling_id = substr($bundling_id,16,-2);
        // }
        // $get_bundling_id = $this->coursebundling->getBundlingId();
        
        // Get Data Course
        $get_course_id = $this->coursebundling->getCourseId();
        $course_id = json_encode($get_course_id);
        $data_course_id = substr($course_id,14,-2);
        

        $data = [
            // 'coursebundling' => $get_course_bundling,
            // 'bundling' => $this->coursebundling->getDataBundling($data_bundling_id),
            // 'bundling' => $this->coursebundling->getData(),
            // 'course' => $this->coursebundling->getDataCourse($data_course_id),
            // ['course' => $this->coursebundling->getData()],
                // 'course' => $this->coursebundling->getCourse(),
                // 'course' => $this->coursebundling->getData(),
                // 'course' => $this->coursebundling->with('groups')getData(),
                // 'bundling' => $this->bundling->getBundling(),
            // $this->coursebundling->getDataBundling($bundling_id),
            // $bundling_id,
            'bundling' => [
                // $databundlingid,
                // $get_bundling_id,
                $data_bundling_id,
                // $data_course_id,
            ],
            // $course_id,
            
            // ],
            // 'coursebundling' => $this->coursebundling->orderBy('course_bundling_id', 'DESC')->findAll(),
            // 'course' => $this->coursebundling->getCourse(),
            // 'course' => $this->coursebundling->getData(),
            // 'course' => $this->coursebundling->with('groups')getData(),
            // 'bundling' => $this->bundling->getBundling(),
        ];
        return $this->respond($data);
    }

    public function show($id = null){
        $data = $this->coursebundling->where('course_bundling_id', $id)->getShow($id);
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Data Course Bundling tidak ditemukan');
        }
    }

    public function delete($id = null){
        $data = $this->coursebundling->where('course_bundling_id', $id)->findAll();
        if($data){
            $this->coursebundling->delete($id);
                $response = [
                    'status'   => 200,
                    'success'    => 200,
                    'messages' => [
                        'success' => 'Course Bundling berhasil dihapus'
                    ]
                ];
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('Data Course Bundling tidak ditemukan');
        }
    }
}
