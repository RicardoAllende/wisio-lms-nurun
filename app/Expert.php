<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
    protected $fillable = [
        'title',
        'institute',
        'pecialties',
        'summary'
    ];

    public function module(){
    	return $this->belongsTo('App\Module');
    }

}
