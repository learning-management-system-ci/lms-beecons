<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseTagSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'course_id' => 1,
                'tag_id' => 1,
            ],
            [
                'course_id' => 1,
                'tag_id' => 2,
            ],

            [
                'course_id' => 1,
                'tag_id' => 3,
            ],

            [
                'course_id' => 2,
                'tag_id' => 1,
            ],
            [
                'course_id' => 2,
                'tag_id' => 2,
            ],
            [
                'course_id' => 2,
                'tag_id' => 3,
            ],

            [
                'course_id' => 3,
                'tag_id' => 1,
            ],
            [
                'course_id' => 3,
                'tag_id' => 2,
            ],
            [
                'course_id' => 3,
                'tag_id' => 3,
            ],

            [
                'course_id' => 4,
                'tag_id' => 1,
            ],

            [
                'course_id' => 5,
                'tag_id' => 2,
            ],

            [
                'course_id' => 6,
                'tag_id' => 3,
            ],

            [
                'course_id' => 7,
                'tag_id' => 1,
            ],
            [
                'course_id' => 7,
                'tag_id' => 2,
            ],
            [
                'course_id' => 7,
                'tag_id' => 3,
            ],

            [
                'course_id' => 8,
                'tag_id' => 1,
            ],

            [
                'course_id' => 9,
                'tag_id' => 2,
            ],

            [
                'course_id' => 10,
                'tag_id' => 3,
            ],

            [
                'course_id' => 11,
                'tag_id' => 1,
            ],
            [
                'course_id' => 11,
                'tag_id' => 2,
            ],
            [
                'course_id' => 11,
                'tag_id' => 3,
            ],

            [
                'course_id' => 12,
                'tag_id' => 1,
            ],
            [
                'course_id' => 12,
                'tag_id' => 2,
            ],
            [
                'course_id' => 12,
                'tag_id' => 3,
            ],
        ];

        $this->db->table('course_tag')->insertBatch($data);
    }
}
