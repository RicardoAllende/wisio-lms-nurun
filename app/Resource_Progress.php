<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource_Progress extends Model
{
    protected $table = "resource_progress";

    protected $fillable = ['status'];

    public function user(){

    	return $this->belongsTo('App\User');
    }

}
