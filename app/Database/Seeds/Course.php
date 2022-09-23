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

        // COURSE TAG
        for($i = 1; $i <= $no; $i++){
            array_push($course_tag, [
                'course_id' => $i,
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

        $this->db->table('course')->insertBatch($course);
        $this->db->table('category')->insertBatch($category);
        $this->db->table('tag')->insertBatch($tag);
        $this->db->table('course_category')->insertBatch($course_category);
        $this->db->table('course_tag')->insertBatch($course_tag);
    }
}
