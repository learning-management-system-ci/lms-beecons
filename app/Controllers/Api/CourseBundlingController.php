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
        $data['bundling'] = $this->coursebundling->orderBy('bundling_id', 'DESC')->findAll();
        return $this->respond($data);
    }
}
