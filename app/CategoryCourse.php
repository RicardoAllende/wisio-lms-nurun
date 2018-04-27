<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryCourse extends Model
{
    protected $table = 'category_course';
    protected $fillable = ['category_id', 'course_id'];
}
