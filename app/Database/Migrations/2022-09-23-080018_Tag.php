<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tag extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'tag_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'name'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('tag_id', TRUE);
        $this->forge->createTable('tag', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('category');
    }
}
