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
                'bundling_id' => 1,
                'course_id' => 2,
            ],
            [
                'bundling_id' => 1,
                'course_id' => 3,
            ],
            [
                'bundling_id' => 2,
                'course_id' => 4,
            ],
            [
                'bundling_id' => 2,
                'course_id' => 5,
            ],
            [
                'bundling_id' => 2,
                'course_id' => 6,
            ],
            [
                'bundling_id' => 3,
                'course_id' => 7,
            ],
            [
                'bundling_id' => 3,
                'course_id' => 8,
            ],
        ];
        $this->db->table('course_bundling')->insertBatch($data);
    }
}
