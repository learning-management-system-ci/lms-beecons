<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $no = 15;
        $user = [];

        // USER
        $job = [
            [
                'job_name' => 'Mahasiswa',
            ],
            [
                'job_name' => 'Arsitek',
            ],
            [
                'job_name' => 'Engineering',
            ],
        ];

        $role = ['member', 'partner', 'author', 'mentor', 'admin'];
        for($i = 1; $i <= $no; $i++){
            array_push($user, [
                'job_id' => rand(1, count($job)),
                'oauth_id' => rand(1, 1000),
                'fullname' => 'bambang'.rand(1, 100),
                'email' => 'bambang'.rand(1, 100).'@gmail.com',
                'password' => 'bambang'.rand(1, 100),
                'date_birth' => '2022-'.rand(1, 12).'-'.rand(1, 25),
                'address' => 'jl. melati no.'.rand(1, 100),
                'phone_number' => rand(10000, 100000),
                'linkedin' => 'bambang'.rand(1, 100),
                'profile_picture' => 'bambang'.rand(1, 100).'.jpg',
                'role' => $role[rand(1, count($role)-1)],
                'activation_code' => rand(1, 1000),
                'activation_status' => rand(0, 1),
            ]);
        };

        $this->db->table('users')->insertBatch($user);
    }
}
