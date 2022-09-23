<?php

namespace App\Models;

use CodeIgniter\Model;

class Voucher extends Model
{
    protected $table = 'voucher';
    protected $primaryKey = 'voucher_id';
    protected $allowedFields = ['title', 'description', 'start_date', 'due_date', 'is_active', 'code', 'discount_price', 'created_at', 'updated_at'];
}
