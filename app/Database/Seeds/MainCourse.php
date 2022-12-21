<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainCourse extends Seeder
{
    public function run()
    {
        $this->call('JobSeeder');
        $this->call('UserSeeder');
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
        $this->call('CategoryBundlingSeeder');
        $this->call('BundlingSeeder');
        $this->call('CourseBundlingSeeder');
        $this->call('FaqSeeder');
        $this->call('PapSeeder');
        $this->call('VoucherSeeder');
        $this->call('UserVideoSeeder');
        $this->call('UserCourseSeeder');
        $this->call('ReviewSeeder');
        $this->call('TestimoniSeeder');
        $this->call('CartSeeder');
        $this->call('NotificationPublicSeeder');
        $this->call('NotificationSeeder');
        $this->call('ContactUsSeeder');
        $this->call('TagArticleSeeder');
        $this->call('ArticleSeeder');
        $this->call('WebinarSeeder');
        $this->call('UserWebinarSeeder');
        $this->call('ResumeSeeder');
        $this->call('UserNotificationSeeder');

        $this->call('QuizSeeder');
    }
}
