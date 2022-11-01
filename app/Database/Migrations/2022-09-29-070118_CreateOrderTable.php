<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'order_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'snap_token'       => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'           => true,
            ],
            'user_id'       => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'coupon_code'   => [
                'type'          => 'VARCHAR',
                'constraint'    => 50,
                'null'          => true,
            ],
            'discount_price'   => [
                'type'          => 'VARCHAR',
                'constraint'    => 50,
                'null'          => true,
            ],
            'sub_total'   => [
                'type'          => 'VARCHAR',
                'constraint'    => 50,
            ],
            'gross_amount'   => [
                'type'          => 'VARCHAR',
                'constraint'    => 50,
            ],
            'transaction_status'       => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'           => true,
            ],
            'transaction_id'       => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'           => true,
            ],
            'transaction_time datetime default current_timestamp',
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('order_id', TRUE);
        $this->forge->addForeignKey('user_id', 'users', 'id');
        $this->forge->createTable('order', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('order');
    }
}
