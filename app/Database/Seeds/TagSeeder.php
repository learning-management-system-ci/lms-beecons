<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Architecture',
            ],
            [
                'name' => 'Structure',
            ],
            [
                'name' => 'MEP',
            ],
        ];

        $this->db->table('tag')->insertBatch($data);
    }
}
