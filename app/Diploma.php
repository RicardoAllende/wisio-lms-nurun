<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diploma extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'minimum_score', 'minimum_previous_score', 'ascription_id', 'attachment_id', 'diploma_id'];

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

    public function diploma(){
        return $this->belongsTo('App\CertificateTemplate', 'diploma_template_id');
    }

    public function diploma_template(){
        $template = $this->diploma;
        if($template != null){
            return $template->view_name;
        }
        return "";
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

    public function verifyUser($user_id){
        $user = User::find($user_id);
        if($user == null){
            return false;
        }
        $courses = $this->courses()->pluck('course_id');
        foreach($courses as $course){
            if( ! ( $user->hasCompletedEvaluationsFromCourse($course) && $user->hasCourseComplete($course) ) ){
                return false;
            }
        }
        return true;
        // hasCompletedEvaluationsFromCourse
        // hasCourseComplete
    }

    public function evaluation(){
        return $this->hasOne('App\Evaluation');
    }

    public function hasDiplomaEvaluation(){
        if($this->evaluation != null){
            return true;
        }
        return false;
    }

    public function enrolUser($user_id){
        if($this->verifyUser($user_id)){
            if(DiplomaUser::where('user_id', $user_id)->where('diploma_id', $this->id)->count() == 0){
                $this->users()->attach($user_id);
            }
            return true;
        }else{
            return false;
        }
    }

    public function hasUserEnrolled($user_id){
        $this->users()->where('user_id', $user_id);
    }

}
