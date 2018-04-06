<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course_recommended extends Model
{
    protected $table = "courses_featured";

    protected $fillable = ['likes'];

    public function course(){

    	return $this->belongsTo('App\Course');
    }
}
