<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $table = "resources";

    protected $fillable = ['name','type','url','featured_image'];

    public function progress(){

    	return $this->hasOne('App\Resource_Progress');
    }

    public function course(){

    	return $this->belongsTo('App\Course');
    }

}
