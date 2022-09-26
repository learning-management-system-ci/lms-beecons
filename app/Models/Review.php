<?php

namespace App\Models;

use CodeIgniter\Model;

class Review extends Model
{
	protected $DBGroup          = 'default';
    protected $table            = 'user_review';
    protected $primaryKey       = 'user_review_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'course_id', 'feedback', 'score', 'created_at', 'updated_at'];
}