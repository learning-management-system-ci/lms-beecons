<?php

namespace App\Models;

use CodeIgniter\Model;

class Testimoni extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'testimoni';
    protected $primaryKey       = 'testimoni_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'testimoni', 'created_at', 'updated_at'];

    function getTestimoni(){
        $builder = $this->db->table('testimoni');
        $builder->select('*');
        $query = $builder->get();
        return $query->getResultArray();
    }

    function getDataUser($data_user_id){
        $builder = $this->db->table('users');
        $builder->select('fullname, job_id, profile_picture');
        $builder->where('id', $data_user_id);
        $query = $builder->get();
        return $query->getResultArray();
	}

    function getShow($id){
        $builder = $this->db->table('testimoni');
        $builder->where('testimoni_id', $id);
        $query = $builder->get();
        return $query->getResultArray();
	}
}
