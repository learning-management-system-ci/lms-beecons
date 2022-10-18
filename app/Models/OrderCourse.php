<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderCourse extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'order_course';
    protected $primaryKey       = 'order_course_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['order_id', 'course_id'];

    function getData($orderId) {
        $builder = $this->db->table('order_course');
                    $builder->select('*');
                    $builder->where('order_id', $orderId);
                    $builder->join('course','course.course_id=order_course.course_id');
                    $query = $builder->get();
                    return $query;
    }
}
