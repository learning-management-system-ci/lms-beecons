<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CategoryBundling extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'category_bundling_id'          => [
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

        $this->forge->addKey('category_bundling_id', TRUE);
        $this->forge->createTable('category_bundling', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('category_bundling');
    }
}
