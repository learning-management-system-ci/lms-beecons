<?php

namespace App\Models;

use CodeIgniter\Model;

class VideoCategory extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'video_category';
    protected $primaryKey       = 'video_category_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['course_id', 'title', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
