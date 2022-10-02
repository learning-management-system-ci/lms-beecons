<?php

namespace App\Models;

use CodeIgniter\Model;

class UserVideo extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'user_video';
    protected $primaryKey       = 'user_video_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['video_id', 'user_id', 'score', 'created_at', 'updated_at'];

    function getUserVideo(){
        $builder = $this->db->table('user_video');
        $builder->select('*');
        $query = $builder->get();
        return $query->getResultArray();
    }
    
    function getDataVideo($data_video_id){
        $builder = $this->db->table('video');
        $builder->select('*');
        $builder->where('video_id', $data_video_id);
        $query = $builder->get();
        return $query->getResultArray();
	}

    function getDataUser($data_user_id){
        $builder = $this->db->table('users');
        $builder->select('*');
        $builder->where('id', $data_user_id);
        $query = $builder->get();
        return $query->getResultArray();
	}

    function getShow($id){
        $builder = $this->db->table('user_video');
        $builder->where('user_video_id', $id);
        $query = $builder->get();
        return $query->getResultArray();
	}

    function getShowUser($user_id){
        $builder = $this->db->table('user_video');
        $builder->select('*');
        $builder->where('user_id', $user_id);
        $query = $builder->get();
        return $query->getResultArray();
	}
}
