<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TypeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Engineering',
            ],
        ];

        $this->db->table('type')->insertBatch($data);
    }
}
