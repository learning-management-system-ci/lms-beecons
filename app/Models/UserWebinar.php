<?php

namespace App\Models;

use CodeIgniter\Model;

class UserWebinar extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'user_webinar';
    protected $primaryKey       = 'user_webinar_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'webinar_id'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
