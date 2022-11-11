<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Webinar extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'webinar_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'category_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null'            => true,
            ],
            'title' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
            'webinar_type'      => [
                'type'          => "ENUM('Online Webinar','Offline Webinar')",
                'null'             => false
            ],
            'description'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '2500'
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
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('webinar_id', TRUE);
        $this->forge->createTable('webinar', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('webinar');
    }
}
