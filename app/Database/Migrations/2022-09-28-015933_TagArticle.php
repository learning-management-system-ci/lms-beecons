<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TagArticle extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'tag_article_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'name_tag'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('tag_article_id', TRUE);
        $this->forge->createTable('tag_article', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tag_article');
    }
}
