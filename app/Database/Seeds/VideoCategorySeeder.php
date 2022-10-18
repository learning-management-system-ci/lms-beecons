<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class VideoCategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'course_id' => 4,
                'title' => "testt 1",
            ],
            [
                'course_id' => 1,
                'title' => "testt 2",
            ],
            [
                'course_id' => 3,
                'title' => "testt 3",
            ],
            [
                'course_id' => 2,
                'title' => "testt 4",
            ],
            [
                'course_id' => 5,
                'title' => "testt 5",
            ],
            [
                'course_id' => 6,
                'title' => "testt 6",
            ],
            [
                'course_id' => 7,
                'title' => "testt 7",
            ],
        ];
        $this->db->table('video_category')->insertBatch($data);
    }
}
