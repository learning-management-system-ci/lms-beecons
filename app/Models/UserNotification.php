<?php

namespace App\Models;

use CodeIgniter\Model;

class UserNotification extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'user_notification';
    protected $primaryKey       = 'user_notification_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'notification_id', 'read', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
