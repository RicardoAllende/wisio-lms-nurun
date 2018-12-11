<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    protected $fillable = ['id', 'name', 'code'];
    public static function getRequiredAttributes() { return [ 'unique' => [], 'required' => ['name', 'code'] ]; }

    public function users(){
        return $this->hasMany('App\User');
    }

    public function courses(){
        return $this->belongsToMany('App\Course');
    }

    public function experts(){
        return $this->belongsToMany('App\Expert');
    }

}
