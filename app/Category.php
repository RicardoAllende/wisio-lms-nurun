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
        if($img == null){ return 'http://1.bp.blogspot.com/-rGg7seQMfgY/T526kIHkhkI/AAAAAAAAADU/efzshZ8OsEY/s1600/concepto-robado.gif'; }
        return "/".$img->url;
    }

    public function hasMainImg(){
        if($this->attachments->where('type', 'main_img')->count() > 0){ 
            return true;
        }else{
            return false;
        }
    }

}
