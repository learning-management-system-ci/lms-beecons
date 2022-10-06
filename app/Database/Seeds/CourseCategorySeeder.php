<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseCategorySeeder extends Seeder
{
    public function run()
    {
        $no = 15;
        $data = [];

        for($i = 1; $i <= $no; $i++){
            array_push($data, [
                'course_id' => $i,
                'category_id' => 1,
            ]);
        };

        $this->db->table('course_category')->insertBatch($data);
    }
}
