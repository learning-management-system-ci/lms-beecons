<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CourseBundling extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'course_bundling_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'bundling_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null'       => true,
            ],
            'course_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null'       => true,
            ],
            'order'       => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
            'deleted_at datetime',
        ]);

        $this->forge->addKey('course_bundling_id', TRUE);
        $this->forge->addForeignKey('bundling_id', 'bundling', 'bundling_id',  'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('course_id', 'course', 'course_id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('course_bundling', TRUE);
    }


    public function down()
    {
        $this->forge->dropTable('course_bundling');
    }
}
