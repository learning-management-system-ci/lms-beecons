<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Article extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'article_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'tag_article_id' => [
                'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
				'null'			=> true,
            ],
			'title' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
			'sub_title' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
			'content' => [
                'type'           => 'VARCHAR',
                'constraint'     => 10000,
            ],
            'content_image'      => [
                'type'           => 'VARCHAR',
				'constraint'     => 255,
                'null'           => true
			],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('article_id', TRUE);
        $this->forge->addForeignKey('tag_article_id', 'tag_article', 'tag_article_id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('article', TRUE);
    }

    public function down()
    {
		$this->forge->dropTable('article');
    }
}
