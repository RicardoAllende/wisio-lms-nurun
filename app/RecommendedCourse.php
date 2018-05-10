<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecommendedCourse extends Model
{
    protected $fillable = ['likes', 'course_id', 'user_id'];
}
