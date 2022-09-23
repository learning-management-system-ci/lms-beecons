<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseCategorySeeder extends Seeder
{
    public function run()
    {
        $no = 20;
        $data = [];

        for($i = 1; $i <= $no; $i++){
            array_push($data, [
                'course_id' => $i,
                'category_id' => rand(1, 4),
            ]);
        };

        $this->db->table('course_category')->insertBatch($data);
    }
}
