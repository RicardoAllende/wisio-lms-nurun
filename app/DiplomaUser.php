<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiplomaUser extends Model
{
    public $table = "diploma_user";

    protected $fillable = ['diploma_id', 'user_id', 
     'score', 'status', 'ended_at', 'downloaded', 'downloaded_at'];

     public static function getRequiredAttributes() { return []; }
}
