<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionUser extends Model
{
    protected $table = 'question_user';
    protected $fillable = ['question_id', 'user_id','option_id', 'evaluation_user_id'];

    public function users(){
        return $this->belongsToMany('App\User');
    }
    public static function getRequiredAttributes() { return []; }
}
