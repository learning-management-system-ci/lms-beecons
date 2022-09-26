<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseBundling extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'course_bundling';
    protected $primaryKey       = 'course_bundling_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['bundling_id', 'course_id', 'created_at', 'updated_at'];

    function getCourseBundling(){
        $builder = $this->db->table('course_bundling');
        $builder->select('*');
        $query = $builder->get();
        return $query->getResultArray();
	}

    function getDataBundling($data_bundling_id){
        $builder = $this->db->table('bundling');
        $builder->select('*');
        $builder->where('bundling_id', $data_bundling_id);
        $query = $builder->get();
        return $query->getResultArray();
	}

    function getDataCourse($data_course_id){
        $builder = $this->db->table('course');
        $builder->select('*');
        $builder->where('course_id', $data_course_id);
        $query = $builder->get();
        return $query->getResultArray();
	}

    function getShow($id){
        $builder = $this->db->table('course_bundling');
        $builder->select('course.title as title_course, course.description as description_course, course.price as price_course, course.thumbnail, bundling.title as title_bundling, bundling.description as description_bundling, bundling.price as price_bundling');
        $builder->join('course','course.course_id=course_bundling.course_id');
        $builder->join('bundling', 'bundling.bundling_id=course_bundling.bundling_id');
        $builder->where('course_bundling_id', $id);
        $query = $builder->get();
        return $query->getResultArray();
	}
}
