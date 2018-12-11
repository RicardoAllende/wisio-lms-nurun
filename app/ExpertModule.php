<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpertModule extends Model
{
    protected $table = 'expert_module';
    protected $fillable = ['expert_id', 'module_id'];
    public static function getRequiredAttributes() { return [ 'unique' => [], 'required' => ['expert_id', 'module_id'] ]; }
}
