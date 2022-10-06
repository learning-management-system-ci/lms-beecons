<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Fundamental',
            ],
            [
                'name' => 'Intermediate',
            ],
            [
                'name' => 'Advance',
            ],
        ];

        $this->db->table('category')->insertBatch($data);
    }
}
