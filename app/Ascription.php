<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ascription extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'has_constancy',
        'is_pharmacy',
        'maximum_attemps',
        'minimum_score',
        'enabled'
    ];

    public function courses(){
        return $this->belongsToMany('App\Course');
    }

    public function attachments(){
        return $this->belongsToMany('App\Attachment');
    }

    public function users(){
        return $this->belongsToMany('App\User');
    }

    public function hasCourses(){
        if ($this->courses->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getMainImgUrl(){
        $img = $this->attachments->where('type', config('constants.attachments.main_img'))->first();
        if($img == null){ return 'https://upload.wikimedia.org/wikipedia/en/thumb/2/2c/Sanofi.svg/1200px-Sanofi.svg.png'; }
        return "/".$img->url;
    }

    public function hasMainImg(){
        if($this->attachments->where('type', 'main_img')->count() > 0){ 
            return true;
        }else{
            return false;
        }
    }

    public function isPharmacy(){
        if ($this->is_pharmacy == 1) {
            return true;
        } else {
            return false;
        }
    }
}
