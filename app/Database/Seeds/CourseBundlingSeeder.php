<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseBundlingSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'bundling_id' => 1,
                'course_id' => 1,
            ],
            [
                'bundling_id' => 3,
                'course_id' => 1,
            ],
            [
                'bundling_id' => 2,
                'course_id' => 1,
            ],
            [
                'bundling_id' => 1,
                'course_id' => 1,
            ],
            [
                'bundling_id' => 1,
                'course_id' => 1,
            ],
            [
                'bundling_id' => 2,
                'course_id' => 1,
            ],
        ];
        $this->db->table('course_bundling')->insertBatch($data);
    }
}
