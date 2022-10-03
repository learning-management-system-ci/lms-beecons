<?php

namespace App\Models;

use CodeIgniter\Model;

class Jobs extends Model
{
    protected $table = 'jobs';
    protected $primaryKey = 'job_id';
    protected $DBGroup = 'default';
    protected $allowedFields = ['job_name', 'updated_at', 'created_at'];
}
