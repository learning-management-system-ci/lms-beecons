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
            'description'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
            ],
            'price'             => [
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
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('course_id', TRUE);
        $this->forge->createTable('course', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('course');
    }
}
