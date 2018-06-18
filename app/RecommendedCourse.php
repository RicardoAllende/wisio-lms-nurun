<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecommendedCourse extends Model
{
    protected $fillable = ['like', 'course_id', 'user_id'];
}
