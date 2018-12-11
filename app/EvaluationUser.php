<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluationUser extends Model
{
    protected $table = 'evaluation_user';
    protected $fillable = ['evaluation_id', 'user_id', 'status', 'score'];
    public static function getRequiredAttributes() { return [ 'unique' => [], 'required' => ['evaluation_id', 'user_id', 'score'] ]; }
}
