<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

<<<<<<<< HEAD:app/Database/Migrations/2022-09-28-071330_Review.php
class Review extends Migration
========
class UserVideo extends Migration
>>>>>>>> d495be2a9976f038c1a9af52efdb9439630480bf:app/Database/Migrations/2022-09-26-062757_UserVideo.php
{
    public function up() {
        $this->forge->addField([
            'user_video_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'user_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'video_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'score'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '3',
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

<<<<<<<< HEAD:app/Database/Migrations/2022-09-28-071330_Review.php
        $this->forge->addKey('user_review_id', TRUE);
        $this->forge->addForeignKey('user_id', 'users', 'id');
        $this->forge->addForeignKey('course_id', 'course', 'course_id');
        $this->forge->createTable('user_review', TRUE);
========
        $this->forge->addKey('user_video_id', TRUE);
        $this->forge->addForeignKey('user_id', 'users', 'id');
        $this->forge->addForeignKey('video_id', 'video', 'video_id');
        $this->forge->createTable('user_video', TRUE);
>>>>>>>> d495be2a9976f038c1a9af52efdb9439630480bf:app/Database/Migrations/2022-09-26-062757_UserVideo.php
   }


    public function down() {
        $this->forge->dropTable('user_video');
    }
}
