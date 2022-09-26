<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BundlingSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Intermediate',
                'description'    => 'Lorem ipsum dolor sit amet',
                'old_price' => '20000',
                'new_price' => '15000',
            ],
            [
                'title' => 'Intermediate',
                'description'    => 'Lorem ipsum dolor sit amet',
                'old_price' => '20000',
                'new_price' => '15000',
            ],
            [
                'title' => 'Intermediate',
                'description'    => 'Lorem ipsum dolor sit amet',
                'old_price' => '20000',
                'new_price' => '15000',
            ],
            [
                'title' => 'Intermediate',
                'description'    => 'Lorem ipsum dolor sit amet',
                'old_price' => '20000',
                'new_price' => '15000',
            ],
            [
                'title' => 'Intermediate',
                'description'    => 'Lorem ipsum dolor sit amet',
                'old_price' => '20000',
                'new_price' => '15000',
            ],
        ];
        $this->db->table('bundling')->insertBatch($data);
    }
}
