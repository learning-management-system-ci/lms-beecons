<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Course extends Seeder
{
    public function run()
    {
        $no = 20;
        $user = [];
        $course = [];
        $course_category = [];
        $course_tag = [];
        $course_type = [];
        $notification = [];
        $type_tag = [];

        // ======================================================
        // USER
        $job = [
            [
                'job_name' => 'Mahasiswa',
            ],
            [
                'job_name' => 'Arsitek',
            ],
            [
                'job_name' => 'Engineering',
            ],
        ];

        $role = ['member', 'partner', 'author', 'admin'];
        for($i = 1; $i <= $no; $i++){
            array_push($user, [
                'job_id' => rand(1, count($job)),
                'oauth_id' => rand(1, 1000),
                'fullname' => 'bambang'.rand(1, 100),
                'email' => 'bambang'.rand(1, 100).'@gmail.com',
                'password' => 'bambang'.rand(1, 100),
                'date_birth' => '2022-'.rand(1, 12).'-'.rand(1, 25),
                'address' => 'jl. melati no.'.rand(1, 100),
                'phone_number' => rand(10000, 100000),
                'linkedin' => 'bambang'.rand(1, 100),
                'profile_picture' => 'bambang'.rand(1, 100).'.jpg',
                'role' => $role[rand(1, count($role)-1)],
                'activation_code' => rand(1, 1000),
                'activation_status' => rand(0, 1),
            ]);
        };
        // $user = [
        //     [
        //         'job_id' => rand(1, count($job)),
        //         'oauth_id' => rand(1, 1000),
        //         'full_name' => 'bambang'.rand(1, 100),
        //         'email' => 'bambang'.rand(1, 100).'@gmail.com',
        //         'password' => 'bambang'.rand(1, 100),
        //         'date_birth' => '2022-'.rand(1, 12).'-'.rand(1, 25),
        //         'address' => 'jl. melati no.'.rand(1, 100),
        //         'phone_number' => rand(10000, 100000),
        //         'linkedin' => 'bambang'.rand(1, 100),
        //         'profile_picture' => 'bambang'.rand(1, 100).'.jpg',
        //         'role' => $role[rand(1, count($role))],
        //         'activation_code' => rand(1, 1000),
        //         'activation_status' => rand(0, 1),
        //     ],
        // ];

        // ======================================================
        // NOTIFICATION
        for($i = 1; $i <= $no; $i++){
            for($k = 1; $k <= 5; $k++){
                array_push($notification, [
                    'user_id' => $i,
                    'message' => 'Contoh notif '.rand(1, 100),
                ]);
            }
        };
        // public notification
        for($k = 1; $k <= 5; $k++){
            array_push($notification, [
                'message' => 'Contoh public notif '.rand(1, 100),
            ]);
        }

        // ======================================================
        // COURSE
        for($i = 1; $i <= $no; $i++){
            array_push($course, [
                'title' => 'Judul course '.$i,
                'service' => 'course',
                'description' => 'Description course '.$i,
                'old_price' => rand(10000, 1000000),
                'new_price' => rand(10000, 100000),
                'thumbnail' => 'course'.$i.'.jpg',
            ]);
        };

        $category = [
            [
                'name' => 'Fundamental',
            ],
            [
                'name' => 'Basic',
            ],
            [
                'name' => 'Intermediate',
            ],
            [
                'name' => 'Advance',
            ],
        ];

        $tag = [
            [
                'name' => 'UI/UX',
            ],
            [
                'name' => 'FRONTEND',
            ],
            [
                'name' => 'BACKEND',
            ],
            [
                'name' => 'PHP',
            ],
            [
                'name' => 'MYSQL',
            ],
            [
                'name' => 'HTML',
            ],
            [
                'name' => 'JAVASCRIPT',
            ],
        ];

        $type = [
            [
                'name' => 'Arsitek',
            ],
            [
                'name' => 'Engineering',
            ],
        ];

        for($i = 1; $i <= count($course); $i++){
            array_push($course_tag, [
                'course_id' => $i,
                'tag_id' => rand(1, count($tag)),
            ]);

            // Multiple tag
            // course_id 1 tag_id 3 (misal)
            // course_id 1 tag_id 9 (misal)
            // Jadi 1 course, punya 2 tag_id
            array_push($course_tag, [
                'course_id' => rand(1, count($tag)),
                'tag_id' => rand(1, count($tag)),
            ]);
        };

        for($i = 1; $i <= count($course); $i++){
            array_push($course_category, [
                'course_id' => $i,
                'category_id' => rand(1, count($category)),
            ]);
        };

        for($i = 1; $i <= count($course); $i++){
            array_push($course_type, [
                'course_id' => $i,
                'type_id' => rand(1, count($type)),
            ]);
        };

        for($i = 1; $i <= count($course); $i++){
            array_push($type_tag, [
                'type_id' => rand(1, count($type)),
                'tag_id' => rand(1, count($type)),
            ]);
        };

        // ===============================================
        // USER
        $this->db->table('jobs')->insertBatch($job);
        $this->db->table('users')->insertBatch($user);

        // ===============================================
        // NOTIFICATION
        $this->db->table('notification')->insertBatch($notification);

        // ===============================================
        // COURSE
        $this->db->table('course')->insertBatch($course);
        $this->db->table('category')->insertBatch($category);
        $this->db->table('tag')->insertBatch($tag);
        $this->db->table('type')->insertBatch($type);

        $this->db->table('course_category')->insertBatch($course_category);
        $this->db->table('course_tag')->insertBatch($course_tag);
        $this->db->table('course_type')->insertBatch($course_type);

        $this->db->table('type_tag')->insertBatch($type_tag);
    }
}
