<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainCourse extends Seeder
{
    public function run()
    {
        $this->call('CourseNew');
        $this->call('CategorySeeder');
        $this->call('CourseCategorySeeder');
        $this->call('TypeSeeder');
        $this->call('CourseTypeSeeder');
        $this->call('TagSeeder');
        $this->call('TypeTagSeeder');
        $this->call('CourseTagSeeder');
        $this->call('VideoCategoryNew');
        $this->call('VideoNew');
    }
}
