<?php

namespace App\Models;

use CodeIgniter\Model;

class ReferralUser extends Model
{
    protected $table = 'referral_user';
    protected $primaryKey = 'referral_user_id';
    protected $DBGroup = 'default';
    protected $allowedFields = ['referral_id', 'user_id', 'referral_code', 'discount_price', 'is_active'];
}
