<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $no = 20;
        $data = [];

        for($i = 1; $i <= $no; $i++){
            array_push($data, [
                'title' => 'Judul course '.$i,
                'description' => 'Description course '.$i,
                'price' => rand(10000, 1000000),
                'thumbnail' => 'course'.$i.'.jpg',
            ]);
        };

        $this->db->table('course')->insertBatch($data);
    }
}
