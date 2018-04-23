<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleResource extends Model
{
    protected $table = 'module_resource';
    protected $fillable = [
        'module_id',
        'resource_id'
    ];
}
