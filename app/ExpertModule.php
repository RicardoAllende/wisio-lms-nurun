<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpertModule extends Model
{
    protected $table = 'expert_module';
    protected $fillable = ['expert_id', 'module_id'];

}
