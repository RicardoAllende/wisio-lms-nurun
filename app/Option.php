<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = [
        'question_id', 
        'content', 
        'feedback', 
        'score'
    ];
    public function question(){
        return $this->belongsTo('App\Question');
    }
}
