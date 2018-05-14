<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AscriptionUser extends Model
{
    protected $table = 'ascription_user';
    protected $fillable = ['user_id', 'ascription_id', 'score', 'status'];
}
