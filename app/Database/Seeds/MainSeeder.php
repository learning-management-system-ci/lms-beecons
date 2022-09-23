<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        $this->call('CategorySeeder');
        $this->call('CourseCategorySeeder');
        $this->call('CourseSeeder');
        $this->call('FaqSeeder');
        $this->call('JobSeeder');
        $this->call('PapSeeder');
        $this->call('VoucherSeeder');
    }
}
