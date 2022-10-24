<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Testimoni extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'testimoni_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
			'user_id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
				'null'			=> true,
			],
			'testimoni' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'           => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('testimoni_id', TRUE);
        // $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'NO ACTION');
        // $this->forge->addForeignKey(['users_id', 'users_name'], 'users', ['id', 'name'], 'CASCADE', 'CASCADE');
        // $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'NO ACTION');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('testimoni', TRUE);
    }

    public function down()
    {
		$this->forge->dropTable('testimoni');
    }
}
