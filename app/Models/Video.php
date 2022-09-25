<?php

namespace App\Models;

use CodeIgniter\Model;

class Video extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'video';
    protected $primaryKey       = 'video_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['course_id', 'title', 'video', 'order'];

    function getData($id) {
        $builder = $this->db->table('video');
                    $builder->select('video.title as vid_title, video.video, video.order, course.title as course_title, course.description, course.price, course.thumbnail');
                    $builder->where('video.course_id', $id);
                    $builder->join('course','course.course_id=video.course_id');
                    $query = $builder->get();
                    return $query;
    }
}


