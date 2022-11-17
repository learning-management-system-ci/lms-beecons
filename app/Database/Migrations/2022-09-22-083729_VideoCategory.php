<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class VideoCategory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'video_category_id'          => [
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
            'title'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
            'deleted_at datetime',
        ]);

        $this->forge->addKey('video_category_id', TRUE);
        $this->forge->addForeignKey('course_id', 'course', 'course_id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('video_category', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('video_category');
    }
}
