<?php

namespace App\Models;

use CodeIgniter\Model;

class Faq extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'faq';
    protected $primaryKey       = 'faq_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['question', 'answer'];
}
