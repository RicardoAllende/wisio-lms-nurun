<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseTag extends Model
{
    protected $table = "course_tag";

    protected $fillable = [
        'tag_id',
        'course_id'
    ];

    public function course(){

    	return $this->belongsTo('App\Courses');
    }

    public static function getConditions() { return [ 'unique' => [], 'required' => ['course_id', 'tag_id'] ]; }
}
