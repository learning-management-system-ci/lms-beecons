<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderBundling extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'order_bundling';
    protected $primaryKey       = 'order_bundling_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['order_id', 'bundling_id'];

    function getData($orderId) {
        $builder = $this->db->table('order_bundling');
                    $builder->select('*');
                    $builder->where('order_id', $orderId);
                    $builder->join('bundling','bundling.bundling_id=order_bundling.bundling_id');
                    $query = $builder->get();
                    return $query;
    }
}
