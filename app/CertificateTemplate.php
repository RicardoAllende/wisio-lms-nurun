<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CertificateTemplate extends Model
{
    protected $fillable = [
        'name', 'attachment_id'
    ];

    public function courses(){
        return $this->hasMany('App\Course');
    }

    public function hasDependency(){
        if($this->courses->count() > 0){
            return true;
        }
        return false;
    }

    public function attachment(){
        return $this->belongsTo('App\Attachment');
    }

    public function url(){
        return $this->attachment->url;
    }

}
