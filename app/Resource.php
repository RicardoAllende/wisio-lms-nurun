<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $table = "resources";

    protected $fillable = ['attachment_id', 'type', 'previous', 'weight', 'module_id', 'name'];

    public function module(){
    	return $this->belongsTo('App\Module');
    }

    public function users(){
        return $this->belongsToMany('App\User');
    }

    public function evaluations(){
        return $this->hasMany('App\Evaluation');
    }

    public function attachment(){
        return $this->belongsTo('App\Attachment');
    }

    public function url(){
        return '/'.$this->attachment->url;
    }
    public static function getConditions() { return [ 'unique' => [], 'required' => ['type', 'attachment_id', 'module_id'] ]; }

    public static function getSupportedExtensions() { return ['mp4', 'pdf']; }
    public static function isMainImg() { return true; }
}