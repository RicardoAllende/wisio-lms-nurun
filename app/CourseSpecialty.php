<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseSpecialty extends Model
{
    protected $table = 'course_specialty';
    protected $fillable = ['course_id', 'specialty_id'];
}
