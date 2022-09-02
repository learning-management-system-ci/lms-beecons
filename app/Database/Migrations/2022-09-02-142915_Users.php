<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
      $this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
				'auto_increment' => true
			],
      'oauth_id' => [
        'type'           => 'VARCHAR',
        'constraint'     => 50,
        'null'           => true,
      ],
			'fullname'       => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
        'null'           => true,
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
      'activation_code'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			],
		'activation_status'      => [
				'type'           => 'BOOL',
			],
      'created_at datetime default current_timestamp',
      'updated_at datetime default current_timestamp on update current_timestamp',
		]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('users', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
