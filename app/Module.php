<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Module extends Model
{
    protected $fillable = [
        'id',
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

    public function finalEvaluations(){
        return $this->hasMany('App\Evaluation')->where('type', config('constants.evaluations.final'));
    }

    public function diagnosticEvaluations(){
        return $this->hasMany('App\Evaluation')->where('type', config('constants.evaluations.diagnostic'));
    }

    public function hasDiagnosticEvaluation(){
        if ($this->evaluations->where('type', config('constants.evaluations.diagnostic'))->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function hasDiagnosticEvaluationForUser(){
        if(Auth::check()){
            $user = Auth::user();
        }else{
            return false;
        }
        if($this->hasDiagnosticEvaluation()){
            // Expecting only one evaluation
            $evaluation = $this->diagnosticEvaluations->first();
            if( ! $evaluations->hasQuestions()){
                return false;
            }
            if($user->hasThisEvaluationCompleted($evaluation->id)){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }

    public function hasFinalEvaluation(){
        if ($this->evaluations->where('type', config('constants.evaluations.final'))->count() > 0) {
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
        if($img == null){ return config('constants.default_images.ascription'); }
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

    /** Functions only for migrations */
    // public function verifyUser($user){
    //     $evaluation = $this->finalEvaluations->first();
    //     if($evaluation == null){ return false; }
    //     if($user->hasThisEvaluationCompleted($evaluation->id)){
    //         $this->users()->attach($user_id);
    //     }
    // }

    // public function verifyAllUsers(){
    //     $users = User::all();
    //     foreach($users as $user){
    //         verifyUser($user);
    //     }
    //     return "Función terminada";
    // }

    public function calculateUserAvg($user){
        $finalEvaluations = $this->finalEvaluations()->pluck('id');
        $moduleAvg = DB::table('evaluation_user')->select(DB::raw('max(score) as score'))->where('user_id', $user->id)
        ->whereIn('evaluation_id', $finalEvaluations)->groupBy('evaluation_id')->get()->avg('score');
        if($moduleAvg == null){
            return false;
        }else{
            $this->users()->attach($user->id, ['score' => $moduleAvg]);
        }
    }

    public function calculateAvg(){
        $users = User::all();
        foreach($users as $user){
            $this->calculateUserAvg($user);
        }
        return "Función terminada";
    }

}