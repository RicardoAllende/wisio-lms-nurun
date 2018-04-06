<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course_tag extends Model
{
    protected $table = "course_tag";

    public function course(){

    	return $this->belongsTo('App\Courses');
    }

}
