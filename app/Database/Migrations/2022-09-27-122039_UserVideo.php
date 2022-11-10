<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserVideo extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_video_id'          => [
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
			'video_id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
				'null'			=> true,
			],
			'score'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
				'null'			=> true,
			],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('user_video_id', TRUE);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('video_id', 'video', 'video_id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('user_video', TRUE);
    }

    public function down()
    {
		$this->forge->dropTable('user_video');
    }
}
