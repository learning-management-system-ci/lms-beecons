<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryBundling extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'category_bundling';
    protected $primaryKey       = 'category_bundling_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['category_bundling_id', 'name', 'created_at', 'updated_at'];

}
