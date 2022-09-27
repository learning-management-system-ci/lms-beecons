<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class VoucherSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Gratis Ongkir',
                'description'    => 'Lorem ipsum dolor sit amet',
                'start_date'    => '2022-08-22',
                'due_date'    => '2022-08-29',
                'is_active'    => 1,
                'code' => 'dfasgweo2384134',
                'discount_price' => '50',
            ],
            [
                'title' => 'Gratis Ongkir',
                'description'    => 'Lorem ipsum dolor sit amet',
                'start_date'    => '2022-08-22',
                'due_date'    => '2022-08-29',
                'is_active'    => 0,
                'code' => 'dfasgweo2384134',
                'discount_price' => '50',
            ],
            [
                'title' => 'Gratis Ongkir',
                'description'    => 'Lorem ipsum dolor sit amet',
                'start_date'    => '2022-08-22',
                'due_date'    => '2022-08-29',
                'is_active'    => 1,
                'code' => 'dfasgweo2384134',
                'discount_price' => '50',
            ],
            [
                'title' => 'Gratis Ongkir',
                'description'    => 'Lorem ipsum dolor sit amet',
                'start_date'    => '2022-08-22',
                'due_date'    => '2022-08-29',
                'is_active'    => 1,
                'code' => 'dfasgweo2384134',
                'discount_price' => '50',
            ],
            [
                'title' => 'Gratis Ongkir',
                'description'    => 'Lorem ipsum dolor sit amet',
                'start_date'    => '2022-08-22',
                'due_date'    => '2022-08-29',
                'is_active'    => 0,
                'code' => 'dfasgweo2384134',
                'discount_price' => '50',
            ],


        ];

        // Simple Queries
        // $this->db->query('INSERT INTO users (username, email) VALUES(:username:, :email:)', $data);

        // Using Query Builder
        $this->db->table('voucher')->insertBatch($data);
    }
}
