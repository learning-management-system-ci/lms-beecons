<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdminTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
			'admin_id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
				'auto_increment' => true
			],
			'name'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255'
			],
			'email'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
			],
			'password' => [
				'type'           => 'VARCHAR',
				'constraint'     => 50,
			],
			'phone_number'      => [
				'type'           => 'INT',
				'constraint'     => 50,
			],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
		]);

        $this->forge->addKey('admin_id', TRUE);
        $this->forge->createTable('admin', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('admin');
    }
}