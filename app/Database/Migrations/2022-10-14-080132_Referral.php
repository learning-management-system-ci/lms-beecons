<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Referral extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'referral_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id'      => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'referral_code'      => [
                'type'           => 'VARCHAR',
                'constraint'     => 8,
            ],
            'referral_user'      => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'discount_price'     => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('referral_id', TRUE);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('referral', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('referral');
    }
}
