<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderBundlingTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'order_bundling_id'          => [
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
            'bundling_id'       => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('order_bundling_id', TRUE);
        $this->forge->addForeignKey('order_id', 'order', 'order_id');
        $this->forge->addForeignKey('bundling_id', 'bundling', 'bundling_id');
        $this->forge->createTable('order_bundling', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('order_bundling');
    }
}
