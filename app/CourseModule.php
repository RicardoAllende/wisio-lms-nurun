<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseModule extends Model
{
    protected $table = 'course_module';
    protected $fillable = [
        'course_id',
        'module_id'
    ];
}
