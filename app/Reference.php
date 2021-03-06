<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    protected $fillable = [
        'module_id', 'content'
    ];

    public function module(){
        return $this->belongsTo('App\Module');
    }

    public static function getConditions() { return [ 'unique' => [], 'required' => ['module_id', 'content'] ]; }
}
