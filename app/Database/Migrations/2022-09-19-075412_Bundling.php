<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Bundling extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'bundling_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'title' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'           => true,
            ],
            'description' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'           => true,
            ],
            'price' => [
                'type'           => 'VARCHAR',
                'constraint'     => 10,
                'null'           => true,
            ],
            'new_price'             => [
                'type'          => 'VARCHAR',
                'constraint'    => '10',
                'null'          => true,
            ],
            'thumbnail'             => [
                'type'          => 'VARCHAR',
                'constraint'    => '255'
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('bundling_id', TRUE);
        $this->forge->createTable('bundling', TRUE);
    }


    public function down()
    {
        $this->forge->dropTable('bundling');
    }
}
