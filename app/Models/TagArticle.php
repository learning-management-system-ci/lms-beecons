<?php

namespace App\Models;

use CodeIgniter\Model;

class TagArticle extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tag_article';
    protected $primaryKey       = 'tag_article_id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['tag_articles_id', 'name_tag', 'created_at', 'updated_at'];
}
