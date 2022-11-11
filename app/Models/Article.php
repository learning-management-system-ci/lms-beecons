<?php

namespace App\Models;

use CodeIgniter\Model;

class Article extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'articles';
    protected $primaryKey       = 'articles_id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['articles_id', 'category_articles_id', 'title', 'sub_title', 'content', 'content_image', 'created_at', 'updated_at'];
}
