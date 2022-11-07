<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Voucher extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'voucher_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'title'      => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'description'      => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
            'start_date'      => [
                'type'           => 'DATE',
            ],
            'due_date'      => [
                'type'           => 'DATE',
            ],
            'is_active'      => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'=> 0,
            ],
            'quota'      => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'code'      => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
            ],
            'discount_price'      => [
                'type'           => 'INT',
                'constraint'     => 10,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('voucher_id', TRUE);
        $this->forge->createTable('voucher', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('voucher');
    }
}
