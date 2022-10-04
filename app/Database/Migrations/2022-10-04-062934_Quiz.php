<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Quiz extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'quiz_id'          => [
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
			'question' => [
                'type'           => 'json',
                'null'           => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('quiz_id', TRUE);
        $this->forge->addForeignKey('video_id', 'video', 'video_id', 'CASCADE', 'NO ACTION');
        $this->forge->createTable('quiz', TRUE);
    }

    public function down()
    {
		$this->forge->dropTable('quiz');
    }
}
