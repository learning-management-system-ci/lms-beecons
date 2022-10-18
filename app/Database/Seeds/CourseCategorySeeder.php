<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseCategorySeeder extends Seeder
{
    public function run()
    {
        $no = 15;
        $data = [
            [
                'course_id' => 1,
                'category_id' => 1, 
            ],
            [
                'course_id' => 2,
                'category_id' => 2, 
            ],
            [
                'course_id' => 3,
                'category_id' => 3, 
            ],
            [
                'course_id' => 4,
                'category_id' => 3, 
            ],
            [
                'course_id' => 5,
                'category_id' => 3, 
            ],
            [
                'course_id' => 6,
                'category_id' => 2, 
            ],
        ];

        $this->db->table('course_category')->insertBatch($data);
    }
}
