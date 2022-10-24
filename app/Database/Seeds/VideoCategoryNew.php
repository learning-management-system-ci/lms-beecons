<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class VideoCategoryNew extends Seeder
{
    public function run()
    {
        $data = [
            [
                'course_id' => '1',
                'title' => ''
            ],
            [
                'course_id' => '2',
                'title' => ''
            ],
            [
                'course_id' => '3',
                'title' => ''
            ],
            [
                'course_id' => '4',
                'title' => ''
            ],
            [
                'course_id' => '5',
                'title' => ''
            ],
            [
                'course_id' => '6',
                'title' => ''
            ],
            [
                'course_id' => '7',
                'title' => ''
            ],
            [
                'course_id' => '8',
                'title' => ''
            ],
            [
                'course_id' => '9',
                'title' => ''
            ],
            [
                'course_id' => '10',
                'title' => ''
            ],
            [
                'course_id' => '11',
                'title' => ''
            ],
            [
                'course_id' => '12',
                'title' => ''
            ],
        ];

        $this->db->table('video_category')->insertBatch($data);
    }
}
