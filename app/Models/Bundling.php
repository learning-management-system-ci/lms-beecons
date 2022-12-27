<?php

namespace App\Models;

use CodeIgniter\Model;

class Bundling extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'bundling';
    protected $primaryKey       = 'bundling_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['bundling_id', 'category_bundling_id', 'title', 'description', 'old_price', 'new_price', 'thumbnail', 'author_id', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    function getShow($id)
    {
        $builder = $this->db->table('bundling');
        // $builder->select('*');
        $builder->where('bundling_id', $id);
        $query = $builder->get();
        return $query->getResultArray();
    }

    function getData($id)
    {
        $builder = $this->db->table('bundling');
        // $builder->select('course_bundling.bundling_id as bun');
        $builder->select('course_bundling.bundling_id as bund, course_bundling.course_id');
        $builder->join('course_bundling', 'course_bundling.bundling_id=bundling.bundling_id');
        // $builder->join('course', 'course.course_id=course_bundling.course_id');
        // JOIN course_category ON course.course_id=course_category.course_id
        // JOIN video_category ON course_category.course_id=video_category.course_id
        // JOIN video ON video_category.video_category_id=video.video_category_id
        // WHERE bundling.bundling_id = 1
        $builder->where('bundling_id', $id);
        $query = $builder->get();
        return $query->getResultArray();
    }
}
