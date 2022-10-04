<?php

namespace App\Models;

use CodeIgniter\Model;

class Bundling extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'bundling';
    protected $primaryKey       = 'bundling_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['bundling_id', 'category_bundling_id', 'title', 'description', 'old_price', 'new_price', 'created_at', 'updated_at'];
}