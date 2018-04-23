<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = "tags";

    protected $fillable = ['tag'];

    public function courses(){
    	return $this->belongsToMany('App\Course');
    }
    
}
