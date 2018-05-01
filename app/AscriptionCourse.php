<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AscriptionCourse extends Model
{
    protected $fillable = [
        'ascription_id',
        'course_id'
    ];
}
