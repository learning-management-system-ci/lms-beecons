<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Users;
use App\Models\Jobs;
use Firebase\JWT\JWT;

class MentorController extends ResourceController
{
    public function index()
    {
        $users = new Users;
        $jobs = new Jobs;
        $mentor_data = $users
            ->select('id, job_id, fullname, email, date_birth, address, phone_number, linkedin, profile_picture')
            ->where('role', 'mentor')
            ->findAll(10);

        foreach ($mentor_data as $value) {
            $job_data = $jobs->where('job_id', $value['job_id'])->first();

            $data = [
                'id' => $value['id'],
                'profile_picture' => $value['profile_picture'],
                'fullname' =>  $value['fullname'],
                'email' => $value['email'],
                'date_birth' => $value['date_birth'],
                'job_name' => (is_null($value['job_id'])) ? null : $job_data['job_name'],
                'address' => $value['address'],
                'phone_number' => $value['phone_number'],
                'linkedin' => $value['linkedin'],
            ];

            $response[] = $data;
        }

        if (count($mentor_data) > 0) {
            return $this->respond($response);
        } else {
            return $this->failNotFound('Tidak ada data');
        }
    }

    public function create()
    {
    }
}
