<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JobSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'job_name' => 'Fullstack Developer',
            ],
            [
                'job_name' => 'Frontend Developer',
            ],
            [
                'job_name' => 'Backend Developer',
            ],
            [
                'job_name' => 'UI/UX Designer',
            ],

        ];

        // Simple Queries
        // $this->db->query('INSERT INTO users (username, email) VALUES(:username:, :email:)', $data);

        // Using Query Builder
        $this->db->table('jobs')->insertBatch($data);
    }
}
