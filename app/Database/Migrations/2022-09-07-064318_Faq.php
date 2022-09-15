<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Faq extends Migration {
    public function up() {
     	$this->forge->addField([
			'faq_id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
				'auto_increment' => true
			],
			'question' => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
				'null'           => true,
			],
			'answer'       => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
        		'null'           => true,
			],
			'created_at datetime default current_timestamp',
			'updated_at datetime default current_timestamp on update current_timestamp',
		]);

        $this->forge->addKey('faq_id', TRUE);
        $this->forge->createTable('faq', TRUE);
    }


    public function down() {
        $this->forge->dropTable('faq');
    }
}
