<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'name',
        'featured_image'
    ];

    public function courses(){
    	return $this->belongsToMany('App\Course');
    }

    public function resources(){
    	return $this->belongsToMany('App\Resource');
    }

    public function evaluations(){
    	return $this->hasMany('App\Evaluation');
    }

    public function experts(){
    	return $this->hasMany('App\Experts');
    }
}