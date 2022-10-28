<?php

namespace App\Models;

use CodeIgniter\Model;

class Jobs extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'jobs';
    protected $primaryKey       = 'job_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['job_name', 'updated_at', 'created_at'];

    function updateDataUsers($id){
        $builder = $this->db->table('users');
        $builder->set('job_id', null);
        $builder->where('job_id', $id);
        $builder->update();
	}

}
