<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        $this->call('CourseSeeder');
        $this->call('CategorySeeder');
        $this->call('CourseCategorySeeder');
        $this->call('CategoryBundlingSeeder');
        $this->call('BundlingSeeder');
        $this->call('CourseBundlingSeeder');
        $this->call('FaqSeeder');
        $this->call('JobSeeder');
        $this->call('PapSeeder');
        $this->call('VoucherSeeder');
        $this->call('VideoSeeder');
        $this->call('UserVideoSeeder');
        $this->call('CategorySeeder');
        $this->call('Course');
        $this->call('UserCourseSeeder');
        $this->call('CourseCategorySeeder');
        $this->call('ReviewSeeder');
        $this->call('BundlingSeeder');
        $this->call('VideoCategorySeeder');
    }
}
