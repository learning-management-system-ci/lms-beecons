<?php

namespace App\Models;

use CodeIgniter\Model;

class UserCourse extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'user_course';
    protected $primaryKey       = 'user_course_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'course_id', 'bundling_id', 'is_access'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


    function getData($userId)
    {
        $builder = $this->db->table('user_course');
        $builder->select('*');
        $builder->where('user_id', $userId);
        $builder->join('course', 'course.course_id=user_course.course_id');
        $query = $builder->get();
        return $query;
    }
}
