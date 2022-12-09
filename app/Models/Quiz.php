<?php

namespace App\Models;

use CodeIgniter\Model;

class Quiz extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'quiz';
    protected $primaryKey       = 'quiz_id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['video_id', 'question'];
}
