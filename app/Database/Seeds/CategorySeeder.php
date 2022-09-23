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
                'name' => 'Basic',
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
