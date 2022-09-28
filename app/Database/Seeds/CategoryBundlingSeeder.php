<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoryBundlingSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'FrontEnd',
            ],
            [
                'name' => 'BackEnd',
            ],
            [
                'name' => 'Data Analyst',
            ],
            [
                'name' => 'Cyber Security',
            ],
            [
                'name' => 'Data Engineer',
            ],
        ];

        $this->db->table('category_bundling')->insertBatch($data);
    }
}
