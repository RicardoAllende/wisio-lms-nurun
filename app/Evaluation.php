<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = [
        'module_id',
        'course_id',
        'name', 
        'type', 
        'description',
        'minimum_score',
        'maximum_attemps',
        'start_date',
        'end_date',
        'status'
    ];
    public function module(){
    	return $this->belongsTo('App\Module');
    }

    public function questions(){
    	return $this->hasMany('App\Question');
    }

    public function attachments(){
        return $this->belongsToMany('App\Attachment');
    }

    public function users(){
        return $this->belongsToMany('App\User')->withPivot('status');
    }

    public function img_url(){
        $image = $this->attachments->where('type', config('constants.attachments.main_img'))->first();
        if($image == null){
            return ""; // Default image
        }
        return "/".$image->url;
    }

    public function hasMainImg(){
        if($this->attachments->where('type', config('constants.attachments.main_img'))->count() > 0 ){
            return true;
        }else{
            return false;
        }
    }

}