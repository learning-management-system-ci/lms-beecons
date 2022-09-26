<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        $this->call('FaqSeeder');
        $this->call('JobsSeeder');
        $this->call('PapSeeder');
        $this->call('VoucherSeeder');
        $this->call('CategorySeeder');
        $this->call('CourseCategorySeeder');
        $this->call('Course');
    }
}
