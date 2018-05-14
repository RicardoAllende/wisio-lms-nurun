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
    	return $this->belongsToMany('App\Expert');
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

    public function getMainImgUrl(){
        $img = $this->attachments->where('type', config('constants.attachments.main_img'))->first();
        if($img == null){ return ''; }
        return "/".$img->url;
    }

    public function hasCourses(){
        if ($this->courses->count() > 0) {
            return true;
        } else {
            return false;
        }
        
    }

    public function attachExpert($expert_id){
        if(Expert::find($expert_id) == null ){ return false; }
        if( ! $this->experts->contains($expert_id)){
            $this->experts()->attach($expert_id);
        }
        return false;
    }

    public function detachSpecialty($expert_id){
        return $this->experts()->detach($expert_id);
    }

}