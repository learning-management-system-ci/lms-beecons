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
                'order' => 1,
            ],
            [
                'bundling_id' => 1,
                'course_id' => 2,
                'order' => 2,
            ],
            [
                'bundling_id' => 1,
                'course_id' => 3,
                'order' => 3,
            ],
            [
                'bundling_id' => 2,
                'course_id' => 4,
                'order' => 1,
            ],
            [
                'bundling_id' => 2,
                'course_id' => 5,
                'order' => 2,
            ],
            [
                'bundling_id' => 2,
                'course_id' => 6,
                'order' => 3,
            ],
            [
                'bundling_id' => 3,
                'course_id' => 7,
                'order' => 1,
            ],
            [
                'bundling_id' => 3,
                'course_id' => 8,
                'order' => 1,
            ],
        ];
        $this->db->table('course_bundling')->insertBatch($data);
    }
}
