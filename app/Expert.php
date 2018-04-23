<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
    protected $fillable = [
        'title',
        'institute',
        'studies',
        'experiences',
        'description',
        'module_id'
    ];

    public function module(){
    	return $this->belongsTo('App\Module');
    }

}
