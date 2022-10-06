<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Basic',
            ],
            [
                'name' => 'Intermediate',
            ],
            [
                'name' => 'Advanced',
            ],
        ];

        $this->db->table('category')->insertBatch($data);
    }
}
