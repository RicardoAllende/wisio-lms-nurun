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
        'maximum_score',
        'maximum_attempts',
        'status',
        'previous'
    ];
    public function module(){
    	return $this->belongsTo('App\Module');
    }

    public function users(){
        return $this->belongsToMany('App\User')->withPivot('score', 'status');
    }

    public function questions(){
    	return $this->hasMany('App\Question');
    }

    public function attachments(){
        return $this->belongsToMany('App\Attachment');
    }

    public function enrollments(){
        return $this->belongsToMany('App\User')->withPivot('status');
    }

    public function getMainImgUrl(){
        $img = $this->attachments->where('type', config('constants.attachments.main_img'))->first();
        if($img == null){ return config('constants.default_images.evaluation'); }
        return "/".$img->url;
    }

    public function hasMainImg(){
        if($this->attachments->where('type', config('constants.attachments.main_img'))->count() > 0 ){
            return true;
        }else{
            return false;
        }
    }

    public function attachUser($user_id, $score, $status){
        if(User::find($user_id) != null){
            $this->users()->attach($user_id, ['score' => $score, 'status' => $status]);
        }
    }

    // public function enrolUser($user_id){
    //     if( ! $this->users->contains($user_id)){
    //         $this->attachUser($user_id, 0, config('constants.status.not_attemped'));
    //     }
    // }

}