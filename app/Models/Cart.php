<?php

namespace App\Models;

use CodeIgniter\Model;

class Cart extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'cart';
    protected $primaryKey       = 'cart_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'course_id', 'bundling_id', 'webinar_id'];

    function getCart($userId)
    {
        $builder = $this->db->table('cart');
        $builder->select('*');
        $builder->where('user_id', $userId);
        $query = $builder->get();
        return $query;
    }
}
