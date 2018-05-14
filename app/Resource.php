<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $table = "resources";

    protected $fillable = ['attachment_id', 'type', 'previous'];

    public function modules(){
    	return $this->belongsToMany('App\Module');
    }

    public function users(){
        return $this->belongsToMany('App\User');
    }

    public function evaluations(){
        return $this->hasMany('App\Evaluation');
    }

}
