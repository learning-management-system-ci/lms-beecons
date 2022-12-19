<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NotificationPublicSeeder extends Seeder
{
    public function run()
    {
        $no = 10;
        $notification = [];

        for($i = 1; $i <= $no; $i++){
            array_push($notification, [
                'public' => 1,
                'message' => 'Contoh public notif '.rand(1, 100),
            ]);
        };

        $this->db->table('notification')->insertBatch($notification);
    }
}
