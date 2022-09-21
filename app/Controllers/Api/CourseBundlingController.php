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
        $data['course_bundling'] = $this->coursebundling->orderBy('course_bundling_id', 'DESC')->findAll();
        // $data['course_bundling'] = $this->coursebundling->orderBy('course_bundling_id', 'DESC')->findAll();
        return $this->respond($data);
    }
}
