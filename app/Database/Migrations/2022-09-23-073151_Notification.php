<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Notification extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'notification_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
			'public'      => [
				'type'          => 'BOOL',
				'default' 		=> 0,
				'null' 			=> false,
			],
            'message'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('notification_id', TRUE);
        $this->forge->createTable('notification', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('notification');
    }
}
