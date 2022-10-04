<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderCourseTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'order_course_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'order_id'       => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'course_id'       => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('order_course_id', TRUE);
        $this->forge->addForeignKey('order_id', 'order', 'order_id');
        $this->forge->addForeignKey('course_id', 'course', 'course_id');
        $this->forge->createTable('order_course', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('order_course');
    }
}
