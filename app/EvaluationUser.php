<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluationUser extends Model
{
    protected $table = 'evaluation_user';
    protected $fillable = ['evaluation_id', 'user_id', 'status', 'score'];
}
