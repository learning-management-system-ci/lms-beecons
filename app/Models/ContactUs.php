<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactUs extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'contact_us';
    protected $primaryKey       = 'contact_us_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['contact_us_id', 'email', 'question', 'question_image', 'created_at', 'updated_at'];
}
