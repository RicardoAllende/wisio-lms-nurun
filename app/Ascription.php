<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ascription extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'description',
        'slug'
    ];
}
