<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diploma extends Model
{
    protected $fillable = ['name', 'slug', 'minimum_score', 'minimum_previous_score', 'ascription_id'];

    public function users(){
        return $this->belongsToMany('App\User')->withPivot('score', 'status', 'ended_at', 'downloaded', 'downloaded_at')->withTimestamps();
    }

    public function courses(){
        return $this->belongsToMany('App\Course');
    }

    public function ascription(){
        return $this->belongsTo('App\Ascription');
    }

}
