<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 1,
                'course_id' => 4,
                'feedback'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
                'score' => 3.5,
            ],
            [
                'user_id' => 3,
                'course_id' => 1,
                'feedback'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
                'score' => ' ',
            ],
            [
                'user_id' => 2,
                'course_id' => 3,
                'feedback'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
                'score' => 4.5,
            ],
            [
                'user_id' => 1,
                'course_id' => 2,
                'feedback'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
                'score' => 3.6,
            ],
            [
                'user_id' => 1,
                'course_id' => 1,
                'feedback'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
                'score' => ' ',
            ],
            [
                'user_id' => 2,
                'course_id' => 4,
                'feedback'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
                'score' => 4,
            ],
        ];
        $this->db->table('user_review')->insertBatch($data);
    }
}
