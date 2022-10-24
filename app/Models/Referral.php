<?php

namespace App\Models;

use CodeIgniter\Model;

class Referral extends Model
{
    protected $table = 'referral';
    protected $primaryKey = 'referral_id';
    protected $DBGroup = 'default';
    protected $allowedFields = ['user_id', 'referral_code', 'referral_user', 'discount_price'];
}
