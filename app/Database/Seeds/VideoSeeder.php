<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class VideoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'video_category_id' => 4,
                'title' => 'Lorem Ipsum is simply dummy',
                'video' => 'Video 1',
                'order' => 2,
            ],
            [
                'video_category_id' => 1,
                'title' => 'Lorem Ipsum is simply dummy',
                'video' => 'Video 1',
                'order' => 2,
            ],
            [
                'video_category_id' => 3,
                'title' => 'Lorem Ipsum is simply dummy',
                'video' => 'Video 1',
                'order' => 2,
            ],
            [
                'video_category_id' => 2,
                'title' => 'Lorem Ipsum is simply dummy',
                'video' => 'Video 1',
                'order' => 2,
            ],
            [
                'video_category_id' => 1,
                'title' => 'Lorem Ipsum is simply dummy',
                'video' => 'Video 1',
                'order' => 2,
            ],
            [
                'video_category_id' => 4,
                'title' => 'Lorem Ipsum is simply dummy',
                'video' => 'Video 1',
                'order' => 2,
            ],
        ];
        $this->db->table('video')->insertBatch($data);
    }
}
