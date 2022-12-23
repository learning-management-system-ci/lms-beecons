<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestimoniSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 1,
                'alumni'    => 'Alumni Fullstack',
                'testimoni'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
            ],
            [
                'user_id' => 2,
                'alumni'    => 'Alumni Fullstack',
                'testimoni'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
            ],
            [
                'user_id' => 3,
                'alumni'    => 'Alumni Fullstack',
                'testimoni'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
            ],
            [
                'user_id' => 4,
                'alumni'    => 'Alumni Fullstack',
                'testimoni'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
            ],
            [
                'user_id' => 5,
                'alumni'    => 'Alumni Fullstack',
                'testimoni'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
            ],
        ];
        $this->db->table('testimoni')->insertBatch($data);
    }
}
