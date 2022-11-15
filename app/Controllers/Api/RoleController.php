<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class RoleController extends ResourceController
{
    public function index()
    {
        $data['role'] = ['admin', 'partner', 'author', 'member', 'mentor'];

        return $this->respond($data);
    }
}
