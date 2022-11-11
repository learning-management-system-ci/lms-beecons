<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseCategorySeeder extends Seeder
{
    public function run()
    {
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
            [
                'course_id' => 7,
                'category_id' => 1, 
            ],
            [
                'course_id' => 8,
                'category_id' => 2, 
            ],
            [
                'course_id' => 9,
                'category_id' => 3, 
            ],
            [
                'course_id' => 10,
                'category_id' => 3, 
            ],
            [
                'course_id' => 11,
                'category_id' => 3, 
            ],
            [
                'course_id' => 12,
                'category_id' => 2, 
            ],
            [
                'course_id' => 13,
                'category_id' => 1, 
            ],
            [
                'course_id' => 14,
                'category_id' => 2, 
            ],
            [
                'course_id' => 15,
                'category_id' => 3, 
            ],
            [
                'course_id' => 16,
                'category_id' => 3, 
            ],
            [
                'course_id' => 17,
                'category_id' => 3, 
            ],
            [
                'course_id' => 18,
                'category_id' => 2, 
            ],
            [
                'course_id' => 19,
                'category_id' => 1, 
            ],
            [
                'course_id' => 20,
                'category_id' => 2, 
            ],
            [
                'course_id' => 21,
                'category_id' => 3, 
            ],
            [
                'course_id' => 22,
                'category_id' => 3, 
            ],
            [
                'course_id' => 23,
                'category_id' => 3, 
            ],
            [
                'course_id' => 24,
                'category_id' => 2, 
            ],
            [
                'course_id' => 25,
                'category_id' => 1, 
            ],
            [
                'course_id' => 26,
                'category_id' => 2, 
            ],
            [
                'course_id' => 27,
                'category_id' => 3, 
            ],
            [
                'course_id' => 28,
                'category_id' => 3, 
            ],
            [
                'course_id' => 29,
                'category_id' => 3, 
            ],
            [
                'course_id' => 30,
                'category_id' => 2, 
            ],
        ];

        $this->db->table('course_category')->insertBatch($data);
    }
}
