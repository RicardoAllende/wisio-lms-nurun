<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialtyUser extends Model
{
    protected $table = 'specialty_user';
    protected $fillable = ['specialty_id', 'user_id'];
}
