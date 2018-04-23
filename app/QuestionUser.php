<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionUser extends Model
{
    protected $table = 'question_user';
    protected $fillable = ['question_id', 'user_id','answer'];

    public function users(){
        return $this->belongsToMany('App\User');
    }
}
