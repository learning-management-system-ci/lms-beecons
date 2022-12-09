<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserWebinar extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_webinar_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'user_id'       => [
                'type'           => 'INT',
                'constraint'     => '5',
                'unsigned'       => true,
            ],
            'webinar_id'       => [
                'type'           => 'INT',
                'constraint'     => '5',
                'unsigned'       => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
            'deleted_at datetime',
        ]);

        $this->forge->addKey('user_webinar_id', TRUE);
        $this->forge->addForeignKey('user_id', 'users', 'id');
        $this->forge->addForeignKey('webinar_id', 'webinar', 'webinar_id');
        $this->forge->createTable('user_webinar', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('user_webinar');
    }
}
