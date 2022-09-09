<?php

namespace App\Models;

use CodeIgniter\Model;

class VoucherModel extends Model
{
    protected $table = 'voucher';
    protected $primaryKey = 'voucher_id';
    protected $allowedFields = ['title', 'description', 'code', 'discount_price', 'created_at', 'updated_at'];
}