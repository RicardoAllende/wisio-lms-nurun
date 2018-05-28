<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = [
        'id',
        'question_id', 
        'content', 
        'feedback', 
        'score'
    ];
    public function question(){
        return $this->belongsTo('App\Question');
    }

    public function isCorrect(){
        if ($this->score == 1) {
            return true;
        } else {
            return false;
        }
    }
}
