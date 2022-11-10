<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Webinar;
use App\Models\Users;
use Firebase\JWT\JWT;

class WebinarController extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->webinar = new Webinar();
    }

    public function index(){
        $data['webinar'] = $this->webinar->findAll();
        return $this->respond($data);
    }
    
    public function show($id = null){
        $data = $this->webinar->where('webinar_id', $id)->first();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Data Webinar tidak ditemukan');
        }
    }

    public function create()
    {

    }

    public function update($id = null)
    {
        
    }

    public function delete($id = null)
    {

    }
}