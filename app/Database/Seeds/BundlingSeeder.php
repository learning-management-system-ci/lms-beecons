<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BundlingSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'category_bundling_id' => 1,
                'title' => 'Bundling 1',
                'description'    => 'Lorem ipsum dolor sit amet',
                'old_price' => '20000',
                'new_price' => '15000',
            ],
            [
                'category_bundling_id' => 1,
                'title' => 'Bundling 2',
                'description'    => 'Lorem ipsum dolor sit amet',
                'old_price' => '20000',
                'new_price' => '15000',
            ],
            [
                'category_bundling_id' => 1,
                'title' => 'Bundling 3',
                'description'    => 'Lorem ipsum dolor sit amet',
                'old_price' => '20000',
                'new_price' => '15000',
            ],
            [
                'category_bundling_id' => 1,
                'title' => 'Bundling 4',
                'description'    => 'Lorem ipsum dolor sit amet',
                'old_price' => '20000',
                'new_price' => '15000',
            ],
            [
                'category_bundling_id' => 1,
                'title' => 'Bundling 5',
                'description'    => 'Lorem ipsum dolor sit amet',
                'old_price' => '20000',
                'new_price' => '15000',
            ],
        ];
        $this->db->table('bundling')->insertBatch($data);
    }
}
