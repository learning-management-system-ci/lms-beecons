<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ContactUsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'email' => 'testtt01@gmail.com',
                'question'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
                'question_image' => 'default.png',
            ],
            [
                'email' => 'testtt02@gmail.com',
                'question'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
                'question_image' => ' ',
            ],
            [
                'email' => 'testtt03@gmail.com',
                'question'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
                'question_image' => 'default.png',
            ],
            [
                'email' => 'testtt04@gmail.com',
                'question'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
                'question_image' => 'default.png',
            ],
            [
                'email' => 'testtt05@gmail.com',
                'question'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
                'question_image' => ' ',
            ],
            [
                'email' => 'testtt06@gmail.com',
                'question'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
                'question_image' => ' ',
            ],
        ];
        $this->db->table('contact_us')->insertBatch($data);
    }
}
