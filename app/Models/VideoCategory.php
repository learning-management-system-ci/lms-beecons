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
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['course_id', 'title', 'created_at', 'updated_at'];
}
