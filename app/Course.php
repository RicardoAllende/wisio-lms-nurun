<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ascription;
use App\AscriptionCourse;
use Illuminate\Support\Facades\DB;

class Course extends Model
{
    protected $table = "courses";

    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'minimum_score',
        'has_constancy',
        'enabled',
        'start_date',
        'end_date',
        'category_id',
        'support_email',
        'certificate_template_id'
    ];

    protected $appends = ['img'];

    public function getImgAttribute(){
        return $this->getMainImgUrl();
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
        return $this->belongsToMany('App\User')->withPivot('status', 'score')->withTimeStamps();
    }

    public function approvedUsers(){
        return $this->belongsToMany('App\User')->withPivot('status', 'score')->withTimeStamps()->wherePivot('score', '>=', $this->minimum_score);
    }

    public function failedUsers(){
        return $this->users->count() - $this->approvedUsers->count();
    }

    // public function enrolledUsers(){
    //     return $this->belongsToMany('App\User')->wherePivot('status', config('constants.status.not_attemped'))->withPivot('status', 'score');
    // }

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
        if($this->attachments->where('type', config('constants.attachments.main_img'))->count() > 0){ 
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

    public function attachUser($user_id, $avg){
        if(User::find($user_id) == null){ return false; }
        if($this->users->contains($user_id)){
            $pivot = CourseUser::where('user_id', $user_id)->where('course_id', $this->id)->first();
            $pivot->score = $avg;
            // $pivot->status = $status;
            $pivot->save();
        }else{
            $this->users()->attach($user_id, ['score' => $avg]);
        }
    }

    public function usersAvg(){
        return CourseUser::where('course_id', $this->id)->avg('score');
    }

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
        if($avg == null){
            return false;
        }else{
            $this->attachUser($user_id, $avg);
        }
        return true;
    }

    public function userAvg($user_id){
        $evaluations = $this->finalEvaluations()->pluck('id');
        return DB::table('evaluation_user')->select(DB::raw('max(score) as score'))->where('user_id', $user_id)
        ->whereIn('evaluation_id', $evaluations)->groupBy('evaluation_id')->get()->avg('score');
    }

    public function calculateAvgAllUsers(){
        $users = User::all();
        foreach($users as $user){
            $this->calculateAvgForUser($user->id);
        }
        return "Function end";
    }

    public function numModules(){
        return $this->modules->count();
    }

    public function numUsersEnrolled(){
        return $this->users->count();
    }

    public function certificate_template(){
        return $this->belongsTo('App\CertificateTemplate');
    }

    public function template(){  // Return an image to make a certificate
        $template = $this->certificate_template;
        if($template != null){
            return $template->view_name;
        }
    }

    public function setCourseComplete(){
        $users = $this->users;
        foreach($users as $user){
            if($user->hasCompletedEvaluationsFromCourse($this->id)){
                $enrollment = CourseUser::where('user_id', $user->id)->where('course_id', $this->id)->first();
                $enrollment->status = 1;
                $enrollment->save();
            }
        }
        return "Función terminada";
    }

}
