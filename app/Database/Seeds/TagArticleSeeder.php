<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TagArticleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name_tag' => 'TECHNOLOGY',
            ],
            [
                'name_tag' => 'ARCHITECTURE',
            ],
            [
                'name_tag' => 'HEALTH',
            ],
        ];

        $this->db->table('tag_article')->insertBatch($data);
    }
}
