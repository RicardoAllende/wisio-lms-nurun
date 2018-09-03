<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diploma extends Model
{
    protected $fillable = ['name', 'slug', 'minimum_score', 'minimum_previous_score', 'ascription_id', 'attachment_id'];

    public function users(){
        return $this->belongsToMany('App\User')->withPivot('score', 'status', 'ended_at', 'downloaded', 'downloaded_at')->withTimestamps();
    }

    public function courses(){
        return $this->belongsToMany('App\Course');
    }

    public function ascription(){
        return $this->belongsTo('App\Ascription');
    }

    public function attachment(){
        return $this->belongsTo('App\Attachment');
    }

    public function hasMainImg(){
        if($this->attachment != null){
            return true;
        }
        return false;
    }

    public function getMainImgUrl(){
        if($this->attachment != null){
            return '/'.$this->attachment->url;
        }
        return config('constants.default_images.course');
    }

    public function hasCourseDependency($course_id){
        if( $this->courses()->where('course_id', $course_id)->count() > 0 ){
            return true;
        }
        return false;
    }

    public function attachCourse($course_id){
        if( Course::whereId($course_id)->count() == 0 ){
            return false;
        }
        if( $this->courses()->where('course_id', $course_id)->count() == 0 ){
            $this->courses()->attach($course_id);
        }
        return true;
    }

}
