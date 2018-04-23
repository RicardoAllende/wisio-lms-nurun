<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = ['module_id', 'name', 'type'];
    public function module(){
    	return $this->belongsTo('App\Module');
    }

    public function questions(){
    	return $this->hasMany('App\Question');
    }
}