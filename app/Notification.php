<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'code', 'user_id', 'course_id', 'type', 'accessed'
    ];
}
