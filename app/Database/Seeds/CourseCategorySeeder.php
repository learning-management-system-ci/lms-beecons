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

            [
                'course_id' => 31,
                'category_id' => 2, 
            ],
            [
                'course_id' => 32,
                'category_id' => 2, 
            ],
            [
                'course_id' => 33,
                'category_id' => 2, 
            ],
            [
                'course_id' => 34,
                'category_id' => 2, 
            ],
            [
                'course_id' => 35,
                'category_id' => 2, 
            ],

            [
                'course_id' => 36,
                'category_id' => 3, 
            ],
            [
                'course_id' => 37,
                'category_id' => 3, 
            ],
            [
                'course_id' => 38,
                'category_id' => 3, 
            ],
            [
                'course_id' => 39,
                'category_id' => 3, 
            ],
            [
                'course_id' => 40,
                'category_id' => 3, 
            ],

            [
                'course_id' => 41,
                'category_id' => 2, 
            ],
            [
                'course_id' => 42,
                'category_id' => 2, 
            ],
            [
                'course_id' => 43,
                'category_id' => 2, 
            ],
            [
                'course_id' => 44,
                'category_id' => 2, 
            ],
            [
                'course_id' => 45,
                'category_id' => 2, 
            ],

            [
                'course_id' => 46,
                'category_id' => 3, 
            ],
            [
                'course_id' => 47,
                'category_id' => 3, 
            ],
            [
                'course_id' => 48,
                'category_id' => 3, 
            ],
            [
                'course_id' => 49,
                'category_id' => 3, 
            ],
            [
                'course_id' => 50,
                'category_id' => 3, 
            ],

            [
                'course_id' => 51,
                'category_id' => 3, 
            ],
            [
                'course_id' => 52,
                'category_id' => 3, 
            ],
            [
                'course_id' => 53,
                'category_id' => 3, 
            ],
            [
                'course_id' => 54,
                'category_id' => 3, 
            ],
            [
                'course_id' => 55,
                'category_id' => 3, 
            ],

            [
                'course_id' => 56,
                'category_id' => 2, 
            ],
            [
                'course_id' => 57,
                'category_id' => 2, 
            ],
            [
                'course_id' => 58,
                'category_id' => 2, 
            ],
            [
                'course_id' => 59,
                'category_id' => 2, 
            ],
            [
                'course_id' => 60,
                'category_id' => 2, 
            ],

        ];

        $this->db->table('course_category')->insertBatch($data);
    }
}
