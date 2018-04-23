<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    protected $fillable = [
        'name',
        'type'
    ];
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
