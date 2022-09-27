<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserVideo;
use App\Models\Course;
use App\Models\Video;
use CodeIgniter\HTTP\RequestInterface;

class UserVideoController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index($user_id = null, $course_id = null)
    {
        $model = new UserVideo();
        $modelCourse = new Course();
        $modelVideo = new Video();
        // $data = $model
        //     ->select('users.id')
        //     ->join('users', 'users.id = user_video.user_id')
        //     ->join('video', 'video.video_id = user_video.video_id')
        //     // ->orderBy('course_type_id', 'DESC')
        //     ->where('users.id', $user_id)
        //     ->findAll();
        // $video = $model
        //     ->select('video.*')
        //     ->join('users', 'users.id = user_video.user_id')
        //     ->join('video', 'video.video_id = user_video.video_id')
        //     // ->orderBy('course_type_id', 'DESC')
        //     ->where('users.id', $user_id)
        //     ->findAll();
        $data = $modelCourse
            ->where('course_id', $course_id)
            ->find();
        $video = $modelVideo
            ->where('course_id', $course_id)
            ->findAll();
        // $userVideo = $model
        //     // ->select('user_video.score')
        //     ->join('users', 'users.id = user_video.user_id')
        //     ->join('video', 'video.video_id = user_video.video_id')
        //     // ->orderBy('course_type_id', 'DESC')
        //     ->where('users.id', $user_id)
        //     ->findAll();

        // $course = $model
        //     ->select('course.*')
        //     ->join('course', 'course.course_id = course_type.course_id')
        //     ->join('type', 'type.type_id = course_type.type_id')
        //     ->orderBy('course_type_id', 'DESC')
        //     ->findAll();
        // $type = $model
        //     ->select('type.*')
        //     ->join('course', 'course.course_id = course_type.course_id')
        //     ->join('type', 'type.type_id = course_type.type_id')
        //     ->orderBy('course_type_id', 'DESC')
        //     ->findAll();

        // print_r($userVideo);
        
        for($i = 0; $i < count($data); $i++){
            for($k = 0; $k < count($video); $k++){
                $data[$i]['video'][$k] = $video[$k];
                $userVideo = $model
                    ->select('user_video.score')
                    ->join('users', 'users.id = user_video.user_id')
                    ->join('video', 'video.video_id = user_video.video_id')
                    // ->orderBy('course_type_id', 'DESC')
                    ->where('users.id', $user_id)
                    ->where('video.video_id', $video[$k]['video_id'])
                    ->find();

                if(isset($userVideo[0])){
                    $data[$i]['video'][$k]['score'] = $userVideo[0]['score'];
                }else{
                    $data[$i]['video'][$k]['score'] = null;
                }
                // print_r($userVideo[0]['score']);
                // array_push($data[$i]['video'][$k], $userVideo);
            }
        }

        // return $this->respond($data);

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
}
