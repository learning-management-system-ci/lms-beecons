<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserCourseTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_course_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'user_id'       => [
                'type'           => 'INT',
                'constraint'     => '5',
                'unsigned'       => true,
            ],
            'course_id'       => [
                'type'           => 'INT',
                'constraint'     => '5',
                'unsigned'       => true,
                'null'           => true,
            ],
            'bundling_id'       => [
                'type'           => 'INT',
                'constraint'     => '5',
                'unsigned'       => true,
                'null'           => true,
            ],
            'is_access'             => [
                'type'          => 'BOOL',
            ],

            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
            'deleted_at datetime',
        ]);

        $this->forge->addKey('user_course_id', TRUE);
        $this->forge->addForeignKey('user_id', 'users', 'id');
        $this->forge->addForeignKey('course_id', 'course', 'course_id');
        $this->forge->addForeignKey('bundling_id', 'bundling', 'bundling_id');
        $this->forge->createTable('user_course', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('user_course');
    }
}
