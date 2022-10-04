<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TypeTagSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'type_id' => 1,
                'tag_id' => 1,
            ],
            [
                'type_id' => 1,
                'tag_id' => 2,
            ],
            [
                'type_id' => 1,
                'tag_id' => 3,
            ],
        ];

        $this->db->table('type_tag')->insertBatch($data);
    }
}
