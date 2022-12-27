<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ResumeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'video_id' => 1,
                'user_id' => 15,
                'resume'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
                'task'    => 'test.pdf',
            ],
            [
                'video_id' => 2,
                'user_id' => 15,
                'resume'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
                'task'    => 'test.pdf',
            ],
            [
                'video_id' => 4,
                'user_id' => 14,
                'resume'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
                'task'    => 'test.pdf',
            ],
            [
                'video_id' => 1,
                'user_id' => 5,
                'resume'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
                'task'    => 'test.pdf',
            ],
            [
                'video_id' => 3,
                'user_id' => 15,
                'resume'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
                'task'    => 'test.pdf',
            ],
        ];
        $this->db->table('resume')->insertBatch($data);
    }
}
