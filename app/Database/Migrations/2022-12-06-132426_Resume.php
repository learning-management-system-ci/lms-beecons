<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Resume extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'resume_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'video_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null'			=> true,
            ],
            'user_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null'			=> true,
            ],
            'resume' => [
                'type'           => 'text',
                'null'           => true,
            ],
            'task'      => [
                'type'           => 'VARCHAR',
				'constraint'     => 255,
                'null'           => true
			],

            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('resume_id', TRUE);
        $this->forge->addForeignKey('video_id', 'video', 'video_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('resume', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('resume');
    }
}
