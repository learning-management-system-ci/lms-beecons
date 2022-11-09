<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ReferralUser extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'referral_user_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'referral_id'      => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
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
            'discount_price'     => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'is_active'      => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('referral_user_id', TRUE);
        $this->forge->addForeignKey('referral_id', 'referral', 'referral_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('referral_user', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('referral_user');
    }
}
