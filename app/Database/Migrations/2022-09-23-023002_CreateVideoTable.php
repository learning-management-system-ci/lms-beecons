<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVideoTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'video_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'video_category_id'       => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null'            => true,
            ],
            'title'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'thumbnail'         => [
                'type'          => 'VARCHAR',
                'constraint'    => '255'
            ],
            'video'             => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'order'       => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],

            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('video_id', TRUE);
        $this->forge->addForeignKey('video_category_id', 'video_category', 'video_category_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('video', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('video');
    }
}
