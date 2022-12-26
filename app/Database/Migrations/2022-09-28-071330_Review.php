<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Review extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_review_id'          => [
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
            'course_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null'           => true,
            ],
            'bundling_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null'           => true,
            ],
            'feedback' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
            'score'       => [
                'type'           => 'SMALLINT',
                'constraint'     => 5,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
            'deleted_at datetime',
        ]);

        $this->forge->addKey('user_review_id', TRUE);
        $this->forge->addForeignKey('user_id', 'users', 'id');
        $this->forge->addForeignKey('course_id', 'course', 'course_id');
        $this->forge->addForeignKey('bundling_id', 'bundling', 'bundling_id');
        $this->forge->createTable('user_review', TRUE);
    }


    public function down()
    {
        $this->forge->dropTable('user_review');
    }
}
