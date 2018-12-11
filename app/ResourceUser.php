<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResourceUser extends Model
{
    protected $table = 'resource_user';
    protected $fillable = [
        'status',
        'score',
        'resource_id'
    ];
    public static function getConditions() { return [ 'unique' => [], 'required' => [] ]; }
}
