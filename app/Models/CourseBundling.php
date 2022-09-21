<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseBundling extends Model
{
    protected $table = 'course_bundling';
    protected $primaryKey = 'course_bundling_id';
    protected $allowedFields = ['bundling_id', 'course_id', 'created_at', 'updated_at'];

    public function getCourse()
    {
        return $this->db->table('course_bundling')
        ->join('course','course.course_id=course_bundling.course_id')
        ->join('bundling', 'bundling.bundling_id=course_bundling.bundling_id')
        ->get()->getResultArray();  
    }
}
