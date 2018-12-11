<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'code', 'user_id', 'course_id', 'type', 'accessed'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function course(){
        return $this->belongsTo('App\Course');
    }
    public static function getRequiredAttributes() { return [ 'unique' => [], 'required' => ['code', 'user_id', 'course_id', 'type'] ]; }

}
