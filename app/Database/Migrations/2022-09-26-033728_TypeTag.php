<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TypeTag extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'type_tag_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
			'type_id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
				'null'			=> true,
			],
			'tag_id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
				'null'			=> true,
			],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('type_tag_id', TRUE);
        $this->forge->addForeignKey('type_id', 'type', 'type_id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('tag_id', 'tag', 'tag_id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('type_tag', TRUE);
    }

    public function down()
    {
		$this->forge->dropTable('course_type');
    }
}
