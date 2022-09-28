<?php

namespace App\Models;

use CodeIgniter\Model;

class Cart extends Model
{
    protected $table = 'cart';
    protected $primaryKey = 'cart_id';
    protected $DBGroup = 'default';
    protected $allowedFields = ['user_id', 'course_id', 'bundling_id', 'total'];
}
