<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = [
        'id',
        'module_id',
        'diploma_id',
        'ascription_id',
        'name',
        'type',
        'description',
        'minimum_score',
        'maximum_score',
        'maximum_attempts'
    ];
    public function module(){
    	return $this->belongsTo('App\Module');
    }

    // Diploma evaluation
    public function diploma(){
        return $this->belongsTo('App\Diploma');
    }

    public function isDiplomaEvaluation(){
        if($this->diploma != null ){
            return true;
        }
    }

    public function users(){
        return $this->belongsToMany('App\User')->withPivot('score')->withTimestamps();
    }

    public function questions(){
    	return $this->hasMany('App\Question');
    }

    public function hasQuestions(){
        if ($this->questions->count() > 0) {
            return true;
        }
        return false;
    }

    public function attachments(){
        return $this->belongsToMany('App\Attachment');
    }

    public function enrollments(){
        return $this->belongsToMany('App\User')->withPivot('score')->withTimestamps();
    }

    public function getMainImgUrl(){
        $img = $this->attachments->where('type', config('constants.attachments.main_img'))->first();
        if($img == null){ return config('constants.default_images.evaluation'); }
        return "/".$img->url;
    }

    // public function course(){
    //     return $this->module->course;
    // }

    public function hasMainImg(){
        if($this->attachments->where('type', config('constants.attachments.main_img'))->count() > 0 ){
            return true;
        }else{
            return false;
        }
    }

    public function isFinalEvaluation(){
        if ($this->type == config('constants.evaluations.final')) {
            return true;
        } else {
            return false;
        }
    }

    public function isDiagnosticEvaluation(){
        if($this->type == config('constants.evaluations.diagnostic')){
            return true;
        }
        return false;
    }

}