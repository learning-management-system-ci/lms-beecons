<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        $this->call('CategorySeeder');
        $this->call('CourseSeeder');
        $this->call('CourseCategorySeeder');
        $this->call('FaqSeeder');
        $this->call('JobsSeeder');
        $this->call('PapSeeder');
        $this->call('VoucherSeeder');
    }
}
