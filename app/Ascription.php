<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ascription extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'has_diploma',
        'maximum_attemps',
        'status'
    ];

    public function courses(){
        return $this->belongsToMany('App\Course');
    }

    public function attachments(){
        return $this->belongsToMany('App\Attachment');
    }
}
