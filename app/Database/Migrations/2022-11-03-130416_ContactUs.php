<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ContactUs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'contact_us_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
			'email' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
			'question' => [
                'type'           => 'VARCHAR',
                'constraint'     => 2500,
            ],
            'question_image'      => [
                'type'           => 'VARCHAR',
				'constraint'     => 255,
                'null'           => true
			],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('contact_us_id', TRUE);
        $this->forge->createTable('contact_us', TRUE);
    }

    public function down()
    {
		$this->forge->dropTable('contact_us');
    }
}
