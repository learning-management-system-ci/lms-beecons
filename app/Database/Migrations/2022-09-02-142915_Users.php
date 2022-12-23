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
			'job_id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
				'null'			=> true,
			],
			'oauth_id' => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
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
				'constraint'     => 255,
			],
			'date_birth'      => [
				'type'           => 'DATE',
			],
			'address'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 50,
			],
			'phone_number'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 50,
			],
			'linkedin'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			],
			'profile_picture'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			],
			'role'      => [
				'type'          => 'ENUM("admin", "partner", "author", "member", "mentor")',
				'default' 		=> 'member',
				'null' 			=> false,
			],
			'company' => [
				'type'			=> 'VARCHAR',
				'constraint'    => 255,
				'null'			=> true,
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
		$this->forge->addForeignKey('job_id', 'jobs', 'job_id', 'CASCADE', 'SET NULL');
		$this->forge->createTable('users', TRUE);
	}

	public function down()
	{
		$this->forge->dropTable('users');
	}
}
