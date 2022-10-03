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

    // function getData($id) {
    //     $builder = $this->db->table('video');
    //     $builder->select('video.title as vid_title, video.video, video.order, course.title as course_title, course.description, course.old_price, course.thumbnail');
    //     $builder->where('video.course_id', $id);
    //     $builder->join('course','course.course_id=video.course_id');
    //     $query = $builder->get();
    //     return $query;
    // }

    // function getDataVideo($course_id) {
    //     $builder = $this->db->table('video');
    //     $builder->select('video.video_id, video.course_id, video.title as vid_title, video.video, video.order, user_video.score');
    //     // $builder->where('video.video_id', 'user_video.video_id');
    //     $builder->join('course','course.course_id=video.course_id');
    //     $builder->join('user_video','user_video.video_id=video.video_id');
    //     $builder->where('video.course_id', $course_id);
    //     // $builder->findAll();
    //     $query = $builder->get();
    //     return $query->getResultArray();
    // }

    // function getDataCourse($data_course_id) {
    //     $builder = $this->db->table('video');
    //     $builder->select('video.course_id');
    //     // $builder->where('video.video_id', $data_video_id);
    //     $builder->where('course.course_id', $data_course_id);
    //     $builder->join('course','course.course_id=video.course_id');
    //     $builder->join('user_video','user_video.video_id=video.video_id');
    //     $query = $builder->get();
    //     return $query->getResultArray();
    // }
}


