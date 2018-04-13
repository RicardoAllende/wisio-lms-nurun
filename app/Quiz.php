<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = ['quiz', 'type'];
    public function questions(){
    	return $this->hasMany('App\Question');
    }
}