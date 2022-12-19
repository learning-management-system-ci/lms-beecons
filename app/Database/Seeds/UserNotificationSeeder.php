<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserNotificationSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 15,
                'notification_id'    => 1,
                'read' => 0,
            ],
            [
                'user_id' => 15,
                'notification_id'    => 2,
                'read' => 1,
            ],
            [
                'user_id' => 15,
                'notification_id'    => 13,
                'read' => 0,
            ],
            [
                'user_id' => 15,
                'notification_id'    => 14,
                'read' => 1,
            ],
        ];
        $this->db->table('user_notification')->insertBatch($data);
    }
}
