<?php

namespace App\Models;

use CodeIgniter\Model;

class Voucher extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'voucher';
    protected $primaryKey       = 'voucher_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['title', 'description', 'start_date', 'due_date', 'is_active', 'quota', 'code', 'discount_price', 'created_at', 'updated_at'];
}
