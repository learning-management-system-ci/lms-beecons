<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserCourseSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 1,
                'course_id' => 1,
                'is_access' => 1,
            ],
            [
                'user_id' => 1,
                'course_id' => 3,
                'is_access' => 0,
            ],
            [
                'user_id' => 2,
                'course_id' => 2,
                'is_access' => 1,
            ],
            [
                'user_id' => 1,
                'course_id' => 1,
                'is_access' => 0,
            ],
            [
                'user_id' => 2,
                'course_id' => 3,
                'is_access' => 1,
            ],
        ];
        $this->db->table('user_course')->insertBatch($data);
    }
}
