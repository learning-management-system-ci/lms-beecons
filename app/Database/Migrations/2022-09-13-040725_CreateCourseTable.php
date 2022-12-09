<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCourseTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'course_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'title'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '100'
            ],
            'service'      => [
                'type'          => "ENUM('training','course')",
                'default'         => 'course',
                'null'             => false
            ],
            'description'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
            ],
            'key_takeaways'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'             => true,
            ],
            'suitable_for'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'             => true,
            ],
            'old_price'             => [
                'type'          => 'VARCHAR',
                'constraint'    => '10'
            ],
            'new_price'             => [
                'type'          => 'VARCHAR',
                'constraint'    => '10'
            ],
            'thumbnail'             => [
                'type'          => 'VARCHAR',
                'constraint'    => '255'
            ],
            'author_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null'            => true,
            ],

            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
            'deleted_at datetime',
        ]);

        $this->forge->addKey('course_id', TRUE);
        $this->forge->addForeignKey('author_id', 'users', 'id', 'CASCADE', 'NO ACTION');
        $this->forge->createTable('course', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('course');
    }
}
