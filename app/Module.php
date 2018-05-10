<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'previous'
    ];

    public function courses(){
    	return $this->belongsToMany('App\Course');
    }

    public function resources(){
    	return $this->belongsToMany('App\Resource');
    }

    public function evaluations(){
    	return $this->hasMany('App\Evaluation');
    }

    public function experts(){
    	return $this->hasMany('App\Expert');
    }

    public function hasEvaluations(){
        if ($this->evaluations->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function belongsToCourse($course_id){
        $rows = CourseModule::where('course_id', $course_id)->where('module_id', $this->id)->count();
        if ($rows > 0) {
            return true;
        }else{
            return false;
        }
    }

    public function attachments(){
        return $this->belongsToMany('App\Attachment');
    }

    public function hasMainImg(){
        if ($this->attachments->where('type', 'main_img')->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function users(){
        return $this->belongsToMany('App\User')->withPivot('status');
    }

    public function img_url(){
        $image = $this->attachments->where('type', 'main_img')->first();
        if($image == null){
            return ""; // Default image
        }
        return "/".$image->url;
    }

    public function hasCourses(){
        if ($this->courses->count() > 0) {
            return true;
        } else {
            return false;
        }
        
    }

}