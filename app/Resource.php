<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $table = "resources";

    protected $fillable = ['attahcment_id'];

    public function modules(){
    	return $this->belongsToMany('App\Module');
    }

    // public function progress(){
    // 	return $this->hasOne('App\Resource_Progress');
    // }

    // public function course(){
    // 	return $this->belongsTo('App\Course');
    // }

}
