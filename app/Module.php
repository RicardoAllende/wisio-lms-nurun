<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'name',
        'description',
        'previous',
        'course_id'
    ];

    public function course(){
    	return $this->belongsTo('App\Course');
    }

    public function resources(){
    	return $this->hasMany('App\Resource')->orderBy('weight');
    }

    public function evaluations(){
    	return $this->hasMany('App\Evaluation')->withPivot('status', 'score');
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

    public function hasResources(){
        if ($this->resources->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function numResources(){
        return $this->resources->count();
    }

    public function maxResourceWeight(){
        return $this->resources->max('weight');
    }

    public function belongsToExpert($expert_id){
        if( $this->experts->contains($expert_id) ){
            return true;
        }
        return false;
    }

    public function attachments(){
        return $this->belongsToMany('App\Attachment');
    }

    public function references(){
        return $this->hasMany('App\Reference');
    }

    public function hasReferences(){
        if ($this->references->count() > 0) {
            return true;
        } else {
            return false;
        }
        
    }

    public function hasMainImg(){
        if ($this->attachments->where('type', 'main_img')->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function users(){
        return $this->belongsToMany('App\User')->withPivot('status', 'score');
    }

    public function getMainImgUrl(){
        $img = $this->attachments->where('type', config('constants.attachments.main_img'))->first();
        if($img == null){ return 'https://upload.wikimedia.org/wikipedia/en/thumb/2/2c/Sanofi.svg/1200px-Sanofi.svg.png'; }
        return "/".$img->url;
    }

    public function hasCourse(){
        if ($this->course != null) {
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

    public function detachExpert($expert_id){
        return $this->experts()->detach($expert_id);
    }

    public function attachUser($user_id, $avg, $status){
        if(User::find($user_id) == null ){ return false; }
        $this->users()->attach($user_id, ['score' => $avg, 'status' => $status]);
    }

    // public function enrolUser($user_id){
    //     if( ! $this->users->contains($user_id)){
    //         $this->attachUser($user_id, 0, config('constants.status.not_attemped'));
    //     }
    //     $evaluations = $this->evaluations;
    //     foreach($evaluations as $evaluation){
    //         $evaluation->enrolUser($user_id);
    //     }
    // }

}