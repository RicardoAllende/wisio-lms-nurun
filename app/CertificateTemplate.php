<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CertificateTemplate extends Model
{
    protected $fillable = [
        'name', 'view_name'
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

}
