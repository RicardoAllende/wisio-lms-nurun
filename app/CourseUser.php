<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseUser extends Model
{
    protected $table = 'course_user';
    protected $fillable = [
        'user_id','course_id', 'status', 'score','created_at',
        'updated_at', 'score_in_diplomado'
    ];
    public static function getRequiredAttributes() { return []; }
}
