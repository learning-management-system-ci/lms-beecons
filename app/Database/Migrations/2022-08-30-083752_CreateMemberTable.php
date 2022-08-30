<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMemberTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
			'member_id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
				'auto_increment' => true
			],
			'fullname'       => [
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
			'uid' => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
			],
			'phone_number'      => [
				'type'           => 'INT',
				'constraint'     => 50,
			],
            'activation_code'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
			],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
		]);

        $this->forge->addKey('member_id', TRUE);
        $this->forge->createTable('member', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('member');
    }
}