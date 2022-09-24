<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Course extends Seeder
{
    public function run()
    {
        $no = 20;
        $course = [];
        $course_category = [];
        $course_tag = [];
        $course_type = [];

        // COURSE
        for($i = 1; $i <= $no; $i++){
            array_push($course, [
                'title' => 'Judul course '.$i,
                'description' => 'Description course '.$i,
                'price' => rand(10000, 1000000),
                'thumbnail' => 'course'.$i.'.jpg',
            ]);
        };

        // CATEGORY
        $category = [
            [
                'name' => 'Fundamental',
            ],
            [
                'name' => 'Basic',
            ],
            [
                'name' => 'Intermediate',
            ],
            [
                'name' => 'Advance',
            ],
        ];

        // TAG
        $tag = [
            [
                'name' => 'UI/UX',
            ],
            [
                'name' => 'FRONTEND',
            ],
            [
                'name' => 'BACKEND',
            ],
            [
                'name' => 'PHP',
            ],
            [
                'name' => 'MYSQL',
            ],
            [
                'name' => 'HTML',
            ],
            [
                'name' => 'JAVASCRIPT',
            ],
        ];

        // TYPE
        $type = [
            [
                'name' => 'Arsitek',
            ],
            [
                'name' => 'Engineering',
            ],
        ];

        // COURSE TAG
        for($i = 1; $i <= $no; $i++){
            array_push($course_tag, [
                'course_id' => $i,
                'tag_id' => rand(1, count($tag)),
            ]);

            // Multiple tag
            // course_id 1 tag_id 3 (misal)
            // course_id 1 tag_id 9 (misal)
            // Jadi 1 course, punya 2 tag_id
            array_push($course_tag, [
                'course_id' => rand(1, count($tag)),
                'tag_id' => rand(1, count($tag)),
            ]);
        };

        // COURSE CATEGORY
        for($i = 1; $i <= $no; $i++){
            array_push($course_category, [
                'course_id' => $i,
                'category_id' => rand(1, count($category)),
            ]);
        };

        // COURSE TYPE
        for($i = 1; $i <= $no; $i++){
            array_push($course_type, [
                'course_id' => $i,
                'type_id' => rand(1, count($type)),
            ]);
        };


        $this->db->table('course')->insertBatch($course);
        $this->db->table('category')->insertBatch($category);
        $this->db->table('tag')->insertBatch($tag);
        $this->db->table('type')->insertBatch($type);

        $this->db->table('course_category')->insertBatch($course_category);
        $this->db->table('course_tag')->insertBatch($course_tag);
        $this->db->table('course_type')->insertBatch($course_type);
    }
}
