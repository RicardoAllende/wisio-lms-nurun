<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $fillable = ['email', 'token', 'created_at'];
    public $timestamps = false;
    public static function getConditions() { return [ 'unique' => [], 'required' => ['email', 'token'] ]; }
}
