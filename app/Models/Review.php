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
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'course_id', 'feedback', 'score', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
