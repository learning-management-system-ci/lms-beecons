<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CourseTag extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'course_tag_id'          => [
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
            'tag_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null'            => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
            'deleted_at datetime',
        ]);

        $this->forge->addKey('course_tag_id', TRUE);
        $this->forge->addForeignKey('course_id', 'course', 'course_id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('tag_id', 'tag', 'tag_id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('course_tag', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('course_tag');
    }
}
