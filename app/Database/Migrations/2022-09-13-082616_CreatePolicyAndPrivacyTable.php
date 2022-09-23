<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PolicyAndPrivacy extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'pap_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'value'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('pap_id', TRUE);
        $this->forge->createTable('policy_and_privacy', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('policy_and_privacy');
    }
}
