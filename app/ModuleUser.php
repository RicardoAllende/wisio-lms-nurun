<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleUser extends Model
{
    protected $table = 'module_user';
    protected $fillable = ['module_id', 'user_id', 'status', 'score'];
    public static function getRequiredAttributes() { return [ 'unique' => [], 'required' => ['module_id', 'user_id', 'status'] ]; }
}
