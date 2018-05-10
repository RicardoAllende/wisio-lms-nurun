<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleUser extends Model
{
    protected $table = 'module_user';
    protected $fillable = ['module_id', 'user_id', 'status'];
}
