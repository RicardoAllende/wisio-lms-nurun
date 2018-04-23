<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomFieldUser extends Model
{
    protected $table = "custom_field_user";
    protected $fillable = [
        'user_id',
        'custom_field_id',
        'data'
    ];
}
