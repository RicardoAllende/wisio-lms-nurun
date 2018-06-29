<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FakerMail extends Model
{
    protected $fillable = [
        'email', 'type', 'link'
    ];
}
