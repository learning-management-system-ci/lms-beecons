<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CourseCategory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'course_category_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'course_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null'            => true,
            ],
            'category_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null'            => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
            'deleted_at datetime',
        ]);

        $this->forge->addKey('course_category_id', TRUE);
        $this->forge->addForeignKey('course_id', 'course', 'course_id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('category_id', 'category', 'category_id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('course_category', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('course_category');
    }
}
