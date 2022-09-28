<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BundlingSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Bundling 1',
                'description'    => 'Lorem ipsum dolor sit amet',
                'price' => '20000',
                'new_price' => '10000',
                'thumbnail' => 'image-bundling-1.jpg'
            ],
            [
                'title' => 'Bundling 2',
                'description'    => 'Lorem ipsum dolor sit amet',
                'price' => '20000',
                'new_price' => null,
                'thumbnail' => 'image-bundling-2.jpg'
            ],
            [
                'title' => 'Bundling 3',
                'description'    => 'Lorem ipsum dolor sit amet',
                'price' => '20000',
                'new_price' => '10000',
                'thumbnail' => 'image-bundling-3.jpg'
            ],
            [
                'title' => 'Bundling 4',
                'description'    => 'Lorem ipsum dolor sit amet',
                'price' => '20000',
                'new_price' => '10000',
                'thumbnail' => 'image-bundling-4.jpg'
            ],
            [
                'title' => 'Bundling 5',
                'description'    => 'Lorem ipsum dolor sit amet',
                'price' => '20000',
                'new_price' => '10000',
                'thumbnail' => 'image-bundling-5.jpg'
            ],
        ];
        $this->db->table('bundling')->insertBatch($data);
    }
}
