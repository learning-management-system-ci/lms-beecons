<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserVideoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 1,
                'video_id' => 4,
                'score' => 70,
            ],
            [
                'user_id' => 1,
                'video_id' => 1,
                'score' => 90,
            ],
            [
                'user_id' => 1,
                'video_id' => 3,
                'score' => 90,
            ],
            [
                'user_id' => 1,
                'video_id' => 2,
                'score' => 60,
            ],
            [
                'user_id' => 1,
                'video_id' => 1,
                'score' => 80,
            ],
            [
                'user_id' => 1,
                'video_id' => 4,
                'score' => 70,
            ],
        ];
        $this->db->table('user_video')->insertBatch($data);
    }
}
