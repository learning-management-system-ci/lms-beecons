<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseTypeSeeder extends Seeder
{
    public function run()
    {
        $no = 60;
        $data = [];

        for($i = 1; $i <= $no; $i++){
            array_push($data, [
                'course_id' => $i,
                'type_id' => 1,
            ]);
        };

        $this->db->table('course_type')->insertBatch($data);
    }
}
