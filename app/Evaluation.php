<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = ['module_id', 
        'name', 
        'type', 
        'description',
        'minimum_score',
        'maximum_attemps',
        'start_date',
        'end_date',
        'status'
    ];
    public function module(){
    	return $this->belongsTo('App\Module');
    }

    public function questions(){
    	return $this->hasMany('App\Question');
    }
}