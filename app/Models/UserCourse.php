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
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'course_id', 'is_access'];


    function getData($userId) {
        $builder = $this->db->table('user_course');
                    $builder->select('*');
                    $builder->where('user_id', $userId);
                    $builder->join('course','course.course_id=user_course.course_id');
                    $query = $builder->get();
                    return $query;
        
    }
}
