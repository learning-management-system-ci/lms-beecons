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
            'category_bundling_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null'           => true,
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
            'old_price' => [
                'type'           => 'VARCHAR',
                'constraint'     => 10,
                'null'           => true,
            ],
            'new_price' => [
                'type'           => 'VARCHAR',
                'constraint'     => 10,
                'null'           => true,
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

        $this->forge->addKey('bundling_id', TRUE);
        $this->forge->addForeignKey('category_bundling_id', 'category_bundling', 'category_bundling_id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('author_id', 'users', 'id', 'CASCADE', 'NO ACTION');
        $this->forge->createTable('bundling', TRUE);
    }


    public function down()
    {
        $this->forge->dropTable('bundling');
    }
}
