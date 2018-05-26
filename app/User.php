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
        'lastaccess',
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

    // public function dissociateAllAscriptions(){
    //     $relations = AscriptionUser::where('user_id', $this->id)->get();
    //     foreach($relations as $relation){
    //         $relation->delete();
    //     }
    // }

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

    // public function enrolToAscription($ascription_id){
    //     $ascription = Ascription::find($ascription_id);
    //     if($ascription == null) { return false; }
    //     AscriptionUser::create(['ascription_id' => $ascription->id, 'user_id' => $this->id]);
    // }

    public function belongsToAscription($ascription_id){
        $rows = AscriptionUser::where('ascription_id', $ascription_id)->where('user_id', $this->id)->count();
        if($rows > 0){
            return true;
        }else{
            return false;
        }
    }

    // public function stateInCourse($course_id){
    //     if (Course::find($course_id) != null) {
    //         $pivot = CourseUser::where('user_id', $this->id)->where('course_id', $course_id)->first();
    //         if($pivot == null){
    //             return false;
    //         }
    //         return $pivot->status;
    //     }else{
    //         return false;
    //     }
    // }

    // public function dissociateFromAllAscriptions(){
    //     $relations = AscriptionUser::where('user_id', $this->id);
    //     foreach($relations as $relation){
    //         try{

    //         }catch(\Illuminate\Database\QueryException $e){
                
    //         }
    //         $relation->delete();
    //     }
    // }

    public function evaluations(){
        return $this->belongsToMany('App\Evaluation')->withPivot('id', 'finished', 'score')->withTimestamps();
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

    public function startEvaluation($evaluation_id){
        $evaluation = Evaluation::find($evaluation_id);
        $this->endPreviousAttempts($evaluation_id);
        if( $evaluation == null ) { return false; }
        /** Check how many times the user has done that evaluation */
        // $finalEvaluations = $this->finalEvaluations();
        $tries = $this->evaluations->where('id', $evaluation_id)->count();
        if($evaluation->maximum_attempts > $tries){ // A valid attempt
            // $pivot = $this->evaluations()->attach($evaluation_id);
            $pivot = EvaluationUser::create(['user_id' => $this->id, 'evaluation_id' => $evaluation_id]);
            return $pivot; // With this pivot (id), the user can save his advance in the evaluation
        }else{
            return false;
        }
    }

    public function endPreviousAttempts($evaluation_id){
        // get evaluationsIncompleted
        // loop each evaluation Incomplete
        //     if CheckTime() // no longer than 2 hours or something strtotime() - strtotime
        //         finish
        // return 
    }

    public function finishEvaluation($idTry, $score){
        try{
            $pivot = EvaluationUser::find($idTry);
            $pivot->finished = 1;
            $pivot->score = $score;
            $pivot->save();
            return true;
        }catch(Exception $e){
            return false;
        }
    }
    
    /** Function for the controller */
    // public function gradeEvaluation(Request $request){
    //     $attempt_id = $request->attempt_id;
    //     $user_id = $request->user_id;
    //     $evaluation_id = $request->evaluation_id;
    //     $evaluation = Evaluation::find($evaluation_id);
    //     if($evaluation == null){
    //         // return back(); // Error
    //     }
    //     $user = User::find($user_id);
    //     if($user == null){
    //         // return back(); // Error
    //     }
    //     $questions = $evaluation->questions;
    //     $summatory = 0;
    //     foreach ($questions as $question) {
    //         $id = "question".$question->id;
    //         if($request->filled($id)){
    //             $optionGiven = $request->input($id);
    //             $summatory += $question->scoreOfQuestion($optionGiven);
    //         }
    //     }
    //     $score = $summatory / $questions->count();
    //     $user->finishEvaluation($attempt_id, $evaluation_id);
    // }

}