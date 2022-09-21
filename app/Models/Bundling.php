<?php

namespace App\Models;

use CodeIgniter\Model;

class Bundling extends Model
{
    protected $table = 'bundling';
    protected $primaryKey = 'bundling_id';
    protected $allowedFields = ['bundling_id', 'title', 'description', 'price', 'created_at', 'updated_at'];
}