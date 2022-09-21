<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseBundling extends Model
{
    protected $table = 'course_bundling';
    protected $primaryKey = 'course_bundling_id';
    protected $allowedFields = ['bundling_id', 'course_id', 'created_at', 'updated_at'];
}
