<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CartSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 1,
                'course_id'    => 1,
                'bundling_id'   => null,
            ],
            [
                'user_id' => 1,
                'course_id'    => 2,
                'bundling_id'   => null,
            ],
            [
                'user_id' => 1,
                'course_id'    => null,
                'bundling_id'   => 1,
            ],
            [
                'user_id' => 1,
                'course_id'    => null,
                'bundling_id'   => 2,
            ],
        ];

        // Simple Queries
        // $this->db->query('INSERT INTO users (username, email) VALUES(:username:, :email:)', $data);

        // Using Query Builder
        $this->db->table('cart')->insertBatch($data);
    }
}
