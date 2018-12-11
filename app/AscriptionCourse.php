<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AscriptionCourse extends Model
{
    protected $table = 'ascription_course';
    protected $fillable = [
        'ascription_id',
        'course_id'
    ];
    public static function getRequiredAttributes() { return [ 'unique' => [], 'required' => ['ascription_id', 'course_id'] ]; }
}
