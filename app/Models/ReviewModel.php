<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table = 'user_review';
    protected $primaryKey = 'user_review_id';
    protected $allowedFields = ['user_id', 'course_id', 'feedback', 'score', 'created_at', 'updated_at'];
}
