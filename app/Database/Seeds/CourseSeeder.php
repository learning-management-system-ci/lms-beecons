<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Fluter',
                'description'    => 'Lorem ipsum dolor sit amet',
                'price' => '150000',
                'thumbnail'    => 'thumbnail',
            ],
            [
                'title' => 'React',
                'description'    => 'Lorem ipsum dolor sit amet',
                'price' => '150000',
                'thumbnail'    => 'thumbnail',
            ],
            [
                'title' => 'Codeigniter 3',
                'description'    => 'Lorem ipsum dolor sit amet',
                'price' => '150000',
                'thumbnail'    => 'thumbnail',
            ],
            [
                'title' => 'Laravel 8',
                'description'    => 'Lorem ipsum dolor sit amet',
                'price' => '150000',
                'thumbnail'    => 'thumbnail',
            ],
            [
                'title' => 'Codeigniter 4',
                'description'    => 'Lorem ipsum dolor sit amet',
                'price' => '150000',
                'thumbnail'    => 'thumbnail',
            ],

        ];
        $this->db->table('course')->insertBatch($data);
    }
}
