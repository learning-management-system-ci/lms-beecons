<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        $no = 15;
        $notification = [];

        for($i = 1; $i <= $no; $i++){
            array_push($notification, [
                'user_id' => $i,
                'message' => 'Contoh notif '.rand(1, 100),
            ]);
        };

        $this->db->table('notification')->insertBatch($notification);
    }
}
