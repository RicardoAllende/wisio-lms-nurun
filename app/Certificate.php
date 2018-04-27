<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
     protected $table = "certificates";

     protected $fillable = ['hash', 'course_id', 'user_id'];

    
}
