<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ascription;
use App\RecommendedCourse;
use App\AscriptionCourse;
use Illuminate\Support\Facades\DB;

class Course extends Model
{
    protected $table = "courses";

    protected $fillable = [
        'name',
        'slug',
        'description',
        'maximum_attempts',
        'minimum_score',
        'has_constancy',
        'enabled',
        'start_date',
        'end_date',
        'is_public',
        'category_id'
    ];

    protected $appends = ['img'];

    public function getImgAttribute(){
        return $this->getMainImgUrl();
    }

    public function likes(){
        return RecommendedCourse::where('course_id', $this->id)->count();
    }

    public function recommended(){
        return $this->hasMany('App\RecommendedCourse');
    }

    public function specialties(){
        return $this->belongsToMany('App\Specialty');
    }

    public function hasModules(){
        if($this->modules->count() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function evaluations(){
        $modules = $this->modules;
        $result = collect();
        foreach($modules as $module){
            $result = $result->concat($module->evaluations);
        }
        return $result;
    }

    public function hasEvaluations(){
        if ($this->evaluations->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function belongsToAscription($id){
        $ascription = Ascription::find($id);
        if($ascription == null){ // The ascription doesn't exist
            return false;
        }
        $rows = AscriptionCourse::where('ascription_id', $id)->where('course_id', $this->id)->count();
        if($rows > 0){
            return true;
        }else{
            return false;
        }
    }

    public function hasRelations(){
        if($this->ascriptions->count() > 0){
            return true;
        }
        if($this->modules->count() > 0){
            return true;
        }
        if($this->users->count() > 0){
            return true;
        }
        return false;
    }

    public function ascriptions(){
        return $this->belongsToMany('App\Ascription');
    }

    public function tags(){
    	return $this->belongsToMany('App\Tag');
    }

    public function users(){
        return $this->belongsToMany('App\User')->withPivot('status', 'score');
    }

    public function enrolledUsers(){
        return $this->belongsToMany('App\User')->wherePivot('status', config('constants.status.not_attemped'))->withPivot('status', 'score');
    }

    public function resources(){
    	return $this->hasMany('App\Resource');
    }

    public function category(){
    	return $this->belongsTo('App\Category');
    }

    public function modules(){
    	return $this->hasMany('App\Module');
    }

    public function attachments(){
        return $this->belongsToMany('App\Attachment');
    }

    public function getMainImgUrl(){
        $img = $this->attachments->where('type', config('constants.attachments.main_img'))->first();
        if($img == null){ return config('constants.default_images.course'); } // Default Image
        return "/".$img->url;
    }

    public function hasMainImg(){
        if($this->attachments->where('type', config())->count() > 0){ 
            return true;
        }else{
            return false;
        }
    }

    public function finalEvaluations(){
        $modules = $this->modules;
        $result = collect();
        foreach($modules as $module){
            $result = $result->concat($module->evaluations->where('type', config('constants.evaluations.final')));
        }
        return $result;
    }

    public function diagnosticEvaluations(){
        $modules = $this->modules;
        $result = collect();
        foreach($modules as $module){
            $result = $result->concat($module->evaluations->where('type', config('constants.evaluations.diagnostic')));
        }
        return $result;
    }

    public function attachUser($user_id, $avg, $status){
        if(User::find($user_id) == null){ return false; }
        if($this->users->contains($user_id)){
            $this->users()->detach($user_id);
        }
        $this->users()->attach($user_id, ['score' => $avg, 'status'=> $status]);
    }

    // public function makeAttempt($user_id){
    //     $this->dropPendientAdvances($user_id);
    //     if(User::find($user_id)){ return false; }
    //     $pivots = CourseUser::where('course_id', $this->id)->where('status', config('constants.status.not_attemped'))->get();
    //     foreach($pivots as $pivot){
    //         $pivot->delete();
    //     }
    // }

    // public function dropPendientAdvances($user_id){
    //     $relations = CourseUser::where('course_id', $this->id)->where('user_id', $user_id)
    //         ->where('status', config('constants.status.not_attemped'))->get();
    //     foreach($relations as $relation){
    //         $relation->delete();
    //     }
    // }

    
    public function enrolUser($user_id){
        $user = User::find($user_id);
        if($user == null ){ return false; }
        if( ! $this->users->contains($user_id)){
            $this->users()->attach($user_id);
        }
        return true;
    }

    public function calculateAvgForUser($user_id){
        $evaluations = $this->finalEvaluations()->pluck('id');
        $user = User::find($user_id);
        if($user == null){ return false; }
        $avg = DB::table('evaluation_user')->select(DB::raw('max(score) as score'))->where('user_id', $user_id)
            ->whereIn('evaluation_id', $evaluations)->groupBy('evaluation_id')->get()->avg('score');
        // if ($course->isComplete($user_id)) { // Función pendiente
        //     $status = config('constants.status.completed');
        // } else {
        //     $status = config('constants.status.incomplete');
        // }
        $this->attachUser($user_id, $avg, config('constants.status.incomplete'));
        return true;
    }

    public function numModules(){
        return $this->modules->count();
    }

    // public function saveAdvanceForAllUsers(){
    //     $users = $this->enrolledUsers;
    //     foreach ($users as $user) {
    //         $this->calculateAvgForUser($user->id);
    //     }
    // }
}
