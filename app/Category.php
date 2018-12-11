<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";

    protected $fillable = ['name','description'];

    protected $appends = ['img'];

    public static function getConditions() { return [ 'unique' => [], 'required' => ['name'] ]; }
    public function getImgAttribute(){
        return $this->getMainImgUrl();
    }
    
    public function courses()
    {
    	return $this->hasMany('App\Course');
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
        if($img == null){ return config('constants.default_images.category'); }
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
