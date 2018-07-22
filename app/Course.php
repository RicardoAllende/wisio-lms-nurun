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
        'credits',
        'description',
        'minimum_score',
        'has_constancy',
        'enabled',
        'start_date',
        'end_date',
        'category_id',
        'support_email',
        'has_diploma',
        'certificate_template_id',
        'diploma_template_id'
    ];

    protected $appends = ['img'];

    public function getImgAttribute(){
        return $this->getMainImgUrl();
    }

    public function hasModules(){
        if($this->modules()->count() > 0){
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
        return $this->belongsToMany('App\User')->withPivot('status', 'score', 'score_in_diplomado')->withTimeStamps();
    }

    public function approvedUsers(){
        return $this->belongsToMany('App\User')->withPivot('status', 'score', 'score_in_diplomado')->withTimeStamps()->wherePivot('score', '>=', $this->minimum_score);
    }

    public function completeUsers(){
        return $this->belongsToMany('App\User')->wherePivot('status', 1)->withPivot('status', 'score', 'score_in_diplomado')->withTimeStamps();
    }

    public function incompleteUsers(){
        return $this->belongsToMany('App\User')->wherePivot('status', 0)->withPivot('status', 'score', 'score_in_diplomado')->withTimeStamps();
    }

    public function failedUsers(){
        return $this->users->count() - $this->approvedUsers->count();
    }

    public function resources(){
    	return $this->hasMany('App\Resource');
    }

    public function category(){
    	return $this->belongsTo('App\Category');
    }

    public function modules(){
    	return $this->hasMany('App\Module')->orderBy('sort');
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
        $users = User::cursor();
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

    public function certificate(){
        return $this->belongsTo('App\CertificateTemplate', 'certificate_template_id');
    }

    public function diploma(){
        return $this->belongsTo('App\CertificateTemplate', 'diploma_template_id');
    }

    public function certificate_template(){
        $template = $this->certificate;
        if($template != null){
            return $template->view_name;
        }
        return "";
    }

    public function diploma_template(){
        $template = $this->diploma;
        if($template != null){
            return $template->view_name;
        }
        return "";
    }

    /**
     * For users who have finished this course
     */
    public function setModulesComplete(){
        $users = $this->completeUsers()->cursor();
        foreach($users as $element){
            $user = User::find($element->user_id);
            $modules = $this->modules()->orderBy('id', 'desc')->cursor();
            foreach($modules as $module){
                $pivot = ModuleUser::where('user_id', $user->id)->where('module_id', $module->id)->first();
                if($pivot == null){
                    $user->modules()->attach($module->id, ['status' => 1]);
                }else{
                    $pivot->status = 1;
                    $pivot->save();
                }
            }
        }
    }

    /**
     * This function save the last module advance (the sort has changed, that's why) , for users who haven't finished this course
     */
    public function setLastAdvance(){
        $users = $this->users()->cursor();
        $modules = $this->modules()->pluck('id');
        // return $modules;
        foreach($users as $element){
            $user = User::find($element->user_id);
            if($user != null){
                $completedModules = $user->completedModules()->pluck('module_id');
                $lastModule = 'init';
                foreach($modules as $module){ // Modules ordered by sort
                    if($completedModules->search($module) !== false){
                        $lastModule = $module;
                    }
                }
                if($lastModule != 'init'){
                    $index = $modules->search($lastModule);
                    if($index !== false){
                        for ($i=0; $i < $index; $i++) { 
                            $pivot = ModuleUser::where('user_id', $user->id)->where('module_id', $modules[$i])->first();
                            if($pivot == null){
                                $user->modules()->attach($modules[$i], ['status' => 1]);
                            }else{
                                $pivot->status = 1;
                                $pivot->save();
                            }
                        }
                    }
                }
            }
        }
        return "Finished successfully";
    }

    public function diplomaAvg(){
        return CourseUser::where('course_id', $this->id)->avg('score_in_diplomado');
    }

    public function numUsersWithEvaluation(){
        if( ! $this->has_diploma){
            return 0;
        }
        return CourseUser::where('course_id', $this->id)->whereNotNull('score_in_diplomado')->count();
    }

    public function approvedInDiploma(){
        return CourseUser::where('course_id', $this->id)->where('score_in_diplomado', '>=',  $this->minimum_diploma_score)->count();
    }

    public function diplomaEvaluation(){
        return $this->hasOne('App\Evaluation');
    }

    public function hasDiplomaEvaluation(){
        if($this->diplomaEvaluation){
            return true;
        }
        return false;
    }

    public function setCourseComplete(){
        $users = $this->users()->cursor();
        foreach($users as $user){
            if($user->hasCompletedEvaluationsFromCourse($this->id)){
                $enrollment = CourseUser::where('user_id', $user->id)->where('course_id', $this->id)->first();
                $enrollment->status = 1;
                $enrollment->save();
            }
        }
        return "Función terminada";
    }

    public function setDatesUser($user){
        $dates = $user->finalEvaluationsFromCourse($this->id);
        $pivot = CourseUser::where('user_id', $user->id)->where('course_id', $this->id)->first();
        if($pivot == null){ return false; }
        $pivot->created_at = $dates['start'];
        $pivot->updated_at = $dates['end'];
        $pivot->save();
        return true;
    }

    public function setDateUser($user){
        $dates = $user->initialDate($this->id);
        $pivot = CourseUser::where('user_id', $user->id)->where('course_id', $this->id)->first();
        if($pivot == null){ return false; }
        $pivot->created_at = $dates;
        // $pivot->updated_at = $dates['end'];
        $pivot->save();
        return true;
    }

    public function setDates(){
        $users = $this->users;
        foreach($users as $user){
            $this->setDatesUser($user);
        }
        return true;
    }

    public function setInitialDate(){
        $users = $this->incompleteUsers;
        foreach($users as $user){
            $this->setDateUser($user);
        }
        return true;
    }

}
