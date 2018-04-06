<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enrrollment extends Model
{
    protected $table = "enrrollments";

    protected $fillable = ['status'];

    public function course(){

    	return $this->belongsTo('App\Course');
    }

    public function user(){

    	return $this->belongsTo('App\User');
    }
}
