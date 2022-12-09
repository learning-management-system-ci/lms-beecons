<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserWebinarSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 1,
                'webinar_id' => 1,
            ],
            [
                'user_id' => 1,
                'webinar_id' => 3,
            ],
            [
                'user_id' => 2,
                'webinar_id' => 2,
            ],
            [
                'user_id' => 1,
                'webinar_id' => 1,
            ],
        ];
        $this->db->table('user_webinar')->insertBatch($data);
    }
}
