<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";

    protected $fillable = ['name','description'];

    public function courses()
    {
    	return $this->belongsToMany('App\Course');
    }

    public function attachments(){
        return $this->belongsToMany('App\Attachment');
    }

    public function hasCourses(){
        if($this->courses->count() > 0 ){
            return true;
        }else{
            return false;
        }
    }

    public function getMainImgUrl(){
        $img = $this->attachments->where('type', config('constants.attachments.main_img'))->first();
        if($img == null){
            return "";
        }else{
            return "/".$img->url;
        }
    }

}
