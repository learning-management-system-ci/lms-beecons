<?php

namespace App\Models;

use CodeIgniter\Model;

class Testimoni extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'testimoni';
    protected $primaryKey       = 'testimoni_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'testimoni', 'created_at', 'updated_at'];
}
