<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'evaluation_id',
        'name',
        'content',
        'type',
        'is_true'
    ];
    public function options(){
    	return $this->hasMany('App\Option');
    }

    public function evaluation(){
    	return $this->belongsTo('App\Evaluation');
    }
}