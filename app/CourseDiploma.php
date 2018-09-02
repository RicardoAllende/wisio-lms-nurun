<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseDiploma extends Model
{
    public $table = "course_diploma";

    protected $fillable = ['course_id', 'diploma_id'];
}
