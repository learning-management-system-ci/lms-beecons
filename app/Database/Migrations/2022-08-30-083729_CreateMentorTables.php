<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMentorTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
			'mentor_id'          => [
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
			'phone_number'      => [
				'type'           => 'INT',
				'constraint'     => 50,
			],
            'desc'      => [
				'type'           => 'TEXT',
			],
            'profile_image'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 255
			],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('mentor_id', TRUE);
        $this->forge->createTable('mentor', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('member');
    }
}