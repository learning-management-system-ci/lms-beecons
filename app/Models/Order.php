<?php

namespace App\Models;

use CodeIgniter\Model;

class Order extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'order';
    protected $primaryKey       = 'order_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['order_id', 'snap_token', 'user_id', 'gross_amount', 'transaction_status', 'transaction_time', 'transaction_id'];
}