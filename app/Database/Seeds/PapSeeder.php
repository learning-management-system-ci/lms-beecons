<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PapSeeder extends Seeder
{
    public function run()
    {
        $no = 20;
        $data = [];

        for($i = 1; $i <= $no; $i++){
            array_push($data,     
                [
                    'value' => 'Kamu suka mathca? '.$i,
                ]
            );
        }

        $this->db->table('policy_and_privacy')->insertBatch($data);
    }
}
