<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jobs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'job_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'job_name'          => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],

            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('job_id', TRUE);
        $this->forge->createTable('jobs', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('jobs');
    }
}
