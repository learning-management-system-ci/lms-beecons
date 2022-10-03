<?php

namespace App\Models;

use CodeIgniter\Model;

class Course extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'course';
    protected $primaryKey       = 'course_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['title', 'service', 'description', 'old_price', 'new_price', 'thumbnail'];

    // function getDataCourse($data_course_id){
    //     $builder = $this->db->table('course');
    //     $builderVideo = $this->db->table('user_video');
    //     $builder->select('*');
    //     $builderVideo->select('*');
    //     $builder->where('course_id', $data_course_id);
    //     $builderVideo->where('course_id', $data_course_id);
    //     $query = $builder->get();
    //     $video = 
    //     return $query->getResultArray();
	// }
}
