<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run()
    {
        $no = 15;
        $data = [];

        for($l = 1; $l <= $no; $l++){

            for($i = 1; $i <= 3; $i++){
                array_push($data,     
                    [
                        'video_id' => $l,
                        'question' => '{
                            "quiz": [
                              {
                                "question": "Apa itu kodok?",
                                "answer": [
                                  "Kodok merupakan kodok",
                                  "Kodok merupakan hewan",
                                  "Kodok merupakan manusia",
                                  "Kodok merupakan naga"
                                ],
                                "is_valid": 2
                              },
                              {
                                "question": "Apa itu tanaman?",
                                "answer": [
                                  "Tanaman merupakan kodok",
                                  "Tanaman merupakan hewan",
                                  "Tanaman merupakan Tanaman",
                                  "Tanaman merupakan naga"
                                ],
                                "is_valid": 3
                              },
                              {
                                "question": "Apa itu manusia?",
                                "answer": [
                                  "Manusia merupakan Manusia",
                                  "Manusia merupakan hewan",
                                  "Manusia merupakan manusia",
                                  "Manusia merupakan naga"
                                ],
                                "is_valid": 1
                              }
                            ]
                          }',
                    ]
                );
            }
        }

        $this->db->table('quiz')->insertBatch($data);
    }
}
