<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname', 
        'email', 
        'password',
        'birthday',
        'gender',
        'mobile_phone',
        'postal_code',
        'city',
        'state',
        'address',
        'cedula',
        'consultation_type',
        'last_access',
        'enabled',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function courses(){
        return $this->belongsToMany('App\Course')->withPivot('id', 'status', 'score')->withTimestamps();
    }

    public function modules(){
        return $this->belongsToMany('App\Module')->withPivot('id', 'status', 'score')->withTimestamps();
    }

    public function completedModules(){
        return $this->belongsToMany('App\Module')->wherePivot('status', config('constants.status.completed'))
            ->withPivot('id', 'status', 'score')->withTimestamps();
    }

    public function progressInModule($module_id){
        foreach($this->courses as $course){
            foreach($course->modules as $module){
                if ($module_id == $module->id) {
                    if($this->modules->contains($module_id)){
                        return $this->modules->where('id', $module_id)->first()->pivot->status;
                    }else{
                        return config('constants.status.not_attemped'); // Pendiente
                    }
                }
            }
        }
        return "No inscrito";
    }

    public function availableCourses(){
        $ascription = $this->ascriptions->first();
        if($ascription == null){
            $empty = collect();
            return $empty;
        }
        return $ascription->courses;
    }

    public function hasAvailableEvaluation($evaluation_id){
        foreach($this->modules as $module){
            if ($module->evaluations->contains($evaluation_id)) {
                return true;
            }
        }
        return false;
    }

    public function detachNormalAscriptions(){
        $ascriptions = $this->normalAscriptions();
        foreach($ascriptions as $ascription){
            $this->ascriptions()->detach($ascription->id);
        }
    }

    public function attachAscription($ascription_id){
        $ascription = Ascription::find($ascription_id);
        if($ascription == null){ return false; }
        $this->detachNormalAscriptions();
        $this->ascriptions()->attach($ascription_id);
        return true;
    }

    public function belongsToAscription($ascription_id){
        $rows = AscriptionUser::where('ascription_id', $ascription_id)->where('user_id', $this->id)->count();
        if($rows > 0){
            return true;
        }else{
            return false;
        }
    }

    public function evaluations(){
        return $this->belongsToMany('App\Evaluation')->withPivot('id', 'score')->withTimestamps();
    }

    public function finalEvaluations(){
        return $this->evaluations->where('type', config('constants.evaluations.final'));
    }

    public function diagnosticEvaluations(){
        return $this->evaluations->where('type', config('constants.evaluations.diagnostic'));
    }

    public function progressInEvaluation($evaluation_id){
        $evaluation = Evaluation::find($evaluation_id);
        if ($evaluation == null) { return "Evaluation doesn´t exist"; }
    }

    public function ascriptions()
    {
        return $this->belongsToMany('App\Ascription')->withTimestamps();
    }

    public function normalAscriptions(){
        return $this->ascriptions->where('has_constancy', 0); // Not diplomat
    }

    public function hasAscriptions(){
        if ($this->ascriptions->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function ascription(){
        if($this->hasAscriptions()){
            return $this->ascriptions->first();
        }else{
            return null;
        }
    }

    public function attachments()
    {
        return $this->belongsToMany('App\Attachment')->withTimestamps();
    }

    /**
     * Return answers for the questions the user has answered
     */
    public function answers(){
        return $this->belongsToMany('App\Question')->withTimestamps();
    }


    public function hasRole($role){
        if($this->role->name == $role){
            return true;
        }else{
            return false;
        }
    }

    public function hasAscription(){
        if ($this->ascriptions->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function role(){
        return $this->belongsTo("App\Role");
    } 

    public function isStudent(){
        return $this->hasRole(config('constants.roles.doctor'));
    }

    public function isAdmin(){
        return $this->hasRole(config('constants.roles.admin'));
    }

    public function hasCourses() {
        if ($this->courses->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function isEnrolledInCourse($course_id){
        if($this->courses->contains($course_id)){
            return true;
        }
        return false;
    }

    public function hasAdvance(){
        if($this->hasCourses()){
            return true;
        }
        // Another advances
    }

    public function specialty(){
        return $this->belongsTo('App\Specialty');
    }

    public function ascriptionSlug(){
        $ascription = $this->ascription();
        if($ascription != null){
            return $this->ascription()->slug;
        }
        return "-";
    }

    /**
     * This drop the advance in all evaluations the user has done
     */
    public function resetAdvanceInEvaluations(){
        $this->evaluations()->detach();
    }

    public function resetAdvanceInCourse($course_id){
        $course = Course::find($course_id);
        if($course == null){ return false; }
        $evaluations = $course->finalEvaluations()->pluck('id');
        $this->evaluations()->detach($evaluations);
        return true;
    }

    /**
     * Return true if the course is related to his ascription.
     */
    public function hasAvailableCourse($course_id){
        $course = Course::find($course_id);
        if($course == null ){
            return false;
        }
        $ascription = $this->ascription();
        if ($ascription == null) {
            return false;
        }
        return $ascription->courses->contains($course_id);
    }

    public function gradeEvaluation($evaluation_id, $score){
        $evaluation = Evaluation::find($evaluation_id);
        if ($evaluation == null) { return false; }
        if($this->hasAnotherAttemptInEvaluation($evaluation_id) == false ){ return false; }
        return EvaluationUser::create(['user_id' => $this->id, 'evaluation_id' => $evaluation_id]);
    }

    private function numTriesInEvaluation($evaluation_id){
        return $this->evaluations->where('id', $evaluation_id)->count();
    }

    // If the user has another opportunity to do the evaluation
    public function hasAnotherAttemptInEvaluation($evaluation_id){
        $evaluation = Evaluation::find($evaluation_id);
        if ($evaluation == null) { return false; }
        $tries = $this->numTriesInEvaluation($evaluation_id);
        if($evaluation->maximum_attempts > $tries){ // A valid attempt
            return true;
        }else{
            return false;
        }
    }

    public function setModuleComplete($module_id){
        $module = Module::find($module_id);
        if ($module == null) { return; }
        if($module->hasFinalEvaluation()){ // To complete the module, the user must do the evaluation
            return false;
        }
        if($this->modules->contains($module_id)){
            $this->modules()->detach($module_id);
            ModuleUser::where('user_id', $this->id)->where('module_id', $module_id)->first();
        }
        $this->modules()->attach($module_id, ['status'=>config('constants.status.completed')]);
        return true;
    }

    public function hasCompletedTheModule($module_id){
        $this->modules->contains($module_id);
    }

    public function completedModulesOfCourse($course_id){
        $course = Course::find($course_id);
        if($course == null){ return false; }
        return $this->completedModules->whereIn('id', $course->modules->pluck('id'))->count();
    }

    public function evaluationAttempts($evaluation_id){
        return $this->evaluations->where('id', $evaluation_id)->count();
    }

    public function completedEvaluationsForCourse($course_id){
        $course = Course::find($course_id);
        if($course == null){ return 0; }
        $evaluations = $this->evaluations()->distinct()->pluck('evaluations.id');
        $courseEvalautions = $course->evaluations()->pluck('id');
        $num = 0;
        foreach($courseEvalautions as $evaluation){
            if($evaluations->contains($evaluation)){
                $num++;
            }
        }
        return $num;
    }

    public function scoreInEvaluation($evaluation_id){
        if($this->hasThisEvaluationCompleted($evaluation_id)){
            return EvaluationUser::where('evaluation_id', $evaluation_id)->where('user_id', $this->id)
                ->max('score');
        }else{
            return 0;
        }
    }

    public function scoreInCourse($course_id){
        $pivot = CourseUser::where('course_id', $course_id)->where('user_id', $this->id)->first();
        if($pivot == null){ return '-'; }
        return $pivot->score;
    }

    public function hasThisEvaluationCompleted($evaluation_id){
        return $this->evaluations->contains($evaluation_id);
    }

}