<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ResetPassword extends Migration
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
			'email'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
			],
      'otp_code'      => [
				'type'           => 'INT',
				'constraint'     => 6,
			],
      'created_at datetime default current_timestamp',
      'updated_at datetime default current_timestamp on update current_timestamp',
		]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('reset_password', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('reset_password');
    }
}
