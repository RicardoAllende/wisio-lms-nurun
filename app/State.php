<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['name', 'code'];
    public static function getConditions() { return [ 'unique' => [], 'required' => ['name', 'code'] ]; }
}