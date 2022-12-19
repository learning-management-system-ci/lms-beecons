<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserNotification extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_notification_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'user_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'notification_id'  => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null'			=> true,
            ],
            'read'      => [
				'type'          => 'BOOL',
                'default' 		=> 0,
				'null' 			=> false,
			],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('user_notification_id', TRUE);
        $this->forge->addForeignKey('notification_id', 'notification', 'notification_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('user_notification', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('user_notification');
    }
}
