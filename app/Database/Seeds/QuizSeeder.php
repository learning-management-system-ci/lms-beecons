<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run()
    {
        $no = 310;
        $data = [];

        for ($l = 1; $l <= $no; $l++) {

            for ($i = 1; $i <= 1; $i++) {
                array_push(
                    $data,
                    [
                        'video_id' => $l,
                        'question' => '[
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
                                "question": "Apa itu pitik?",
                                "answer": [
                                  "Pitik merupakan Manusia",
                                  "Pitik merupakan hewan",
                                  "Pitik merupakan pitik",
                                  "Pitik merupakan naga"
                                ],
                                "is_valid": 3
                            },
                            {
                                "question": "Apa itu kenapa?",
                                "answer": [
                                  "Kenapa merupakan kenapa",
                                  "Kenapa merupakan hewan",
                                  "Kenapa merupakan manusia",
                                  "Kenapa merupakan naga"
                                ],
                                "is_valid": 1
                            },
                            {
                                "question": "Apa itu lemur?",
                                "answer": [
                                  "Lemur merupakan Manusia",
                                  "Lemur merupakan hewan",
                                  "Lemur merupakan lemur",
                                  "Lemur merupakan naga"
                                ],
                                "is_valid": 3
                            },
                            {
                                "question": "Apa itu hantu?",
                                "answer": [
                                  "hantu merupakan hantu",
                                  "hantu merupakan hewan",
                                  "hantu merupakan manusia",
                                  "hantu merupakan naga"
                                ],
                                "is_valid": 1
                            },
                            {
                                "question": "Apa itu panda?",
                                "answer": [
                                  "Panda merupakan Manusia",
                                  "Panda merupakan hewan",
                                  "Panda merupakan panda",
                                  "Panda merupakan naga"
                                ],
                                "is_valid": 3
                            },
                            {
                                "question": "Apa itu batu?",
                                "answer": [
                                  "Batu merupakan Manusia",
                                  "Batu merupakan hewan",
                                  "Batu merupakan batu",
                                  "Batu merupakan naga"
                                ],
                                "is_valid": 3
                            },
                            {
                                "question": "Apa itu terserah?",
                                "answer": [
                                  "Terserah merupakan terserah",
                                  "Terserah merupakan hewan",
                                  "Terserah merupakan manusia",
                                  "Terserah merupakan naga"
                                ],
                                "is_valid": 1
                            },
                            {
                                "question": "Apa itu awan?",
                                "answer": [
                                  "Awan merupakan Manusia",
                                  "Awan merupakan hewan",
                                  "Awan merupakan awan",
                                  "Awan merupakan naga"
                                ],
                                "is_valid": 3
                            },
                            {
                                "question": "Apa itu obat?",
                                "answer": [
                                  "Obat merupakan obat",
                                  "Obat merupakan hewan",
                                  "Obat merupakan manusia",
                                  "Obat merupakan naga"
                                ],
                                "is_valid": 1
                            },
                            {
                                "question": "Apa itu riko?",
                                "answer": [
                                  "Riko merupakan Manusia",
                                  "Riko merupakan hewan",
                                  "Riko merupakan biawak",
                                  "Riko merupakan riko"
                                ],
                                "is_valid": 4
                            },
                            {
                                "question": "Apa itu ivan?",
                                "answer": [
                                  "Ivan merupakan Manusia",
                                  "Ivan merupakan hewan",
                                  "Ivan merupakan ivan",
                                  "Ivan merupakan naga"
                                ],
                                "is_valid": 3
                            },
                            {
                                "question": "Apa itu burhan?",
                                "answer": [
                                  "Burhan merupakan Manusia",
                                  "Burhan merupakan Burhan",
                                  "Burhan merupakan biawak",
                                  "Burhan merupakan naga"
                                ],
                                "is_valid": 2
                            },
                            {
                                "question": "Apa itu biawak?",
                                "answer": [
                                  "Biawak merupakan Biawak",
                                  "Biawak merupakan hewan",
                                  "Biawak merupakan manusia",
                                  "Biawak merupakan naga"
                                ],
                                "is_valid": 1
                            }
                        ]',
                    ]
                );
            }
        }

        $this->db->table('quiz')->insertBatch($data);
    }
}
