<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection as Collection;
use App\Ascription;
use App\Course;

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
        'state_id',
        'address',
        'professional_license',
        'consultation_type',
        'last_access',
        'enabled',
        'role_id',
        'is_validated',
        'refered_code'
    ];

    // protected $appends = ['ascription'];

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

    public function coursesFromAscription(Ascription $ascription){
        $coursesEnrolled = $this->courses->pluck('id');
        return $ascription->courses()->whereIn('courses.id', $coursesEnrolled)->get();
    }

    public function coursesIdFromAscription($ascription){
        $coursesEnrolled = $this->courses->pluck('id');
        return $ascription->courses()->whereIn('courses.id', $coursesEnrolled)->pluck('courses.id');
    }

    public function modules(){
        return $this->belongsToMany('App\Module')->withPivot('id', 'status', 'score')->withTimestamps();
    }

    public function completedModules(){
        return $this->belongsToMany('App\Module')->wherePivot('status', 1)
            ->withPivot('id', 'status', 'score')->withTimestamps();
    }

    public function completedCourses(){
        return $this->belongsToMany('App\Course')->wherePivot('status', 1)
        ->withPivot('id', 'status', 'score')->withTimestamps();
    }

    public function resources(){
        return $this->belongsToMany('App\Resource')->withPivot('status')->withTimestamps();
    }

    public function approvedCourses(){
        $courses = $this->completedCourses;
        $result = collect();
        foreach ($courses as $course) {
            if($this->hasCompletedEvaluationsFromCourse($course->id)){
                if($course->pivot->score >= $course->minimum_score){
                    $result->push($course);
                }
            }
        }
        return $result;
    }

    public function availableCertificates(){ // Return the list of courses the user can download
        $courses = $this->approvedCourses();
        $result = collect();
        foreach($courses as $course){
            if($course->has_constancy == 1){
                $result->push($course);
            }
        }
        return $result;
    }

    public function progressInModule($module_id){
        if($this->modules->contains($module_id)){
            $module = $this->modules->find($module_id);
            if($module->hasFinalEvaluation()){
                $finalEvaluation = $module->finalEvaluations()->first();
                if($this->hasThisEvaluationCompleted($finalEvaluation->id)){
                    return '<i class="material-icons">check_box</i> EVALUACIÓN';
                }else{
                    return 'Visto, evaluación pendiente';
                }
            }
            if($this->hasCompletedTheModule($module->id)){
                return "VISTO ".substr($module->created_at, 0, 10); // Show only time
            }
        }
        return "PENDIENTE";
    }

    public function progressInCourse($course_id){
        $pivot = CourseUser::where('course_id', $course_id)->where('user_id', $this->id)->first();
        if($pivot == null) { return "No inscrito"; }
        if($pivot->status == 1){
            return "Completado";
        }else{
            return "No completado";
        }
    }

    public function availableCourses(){
        $ids = collect();
        $ascriptions = $this->allAscriptions;
        foreach($ascriptions as $ascription){
            $array = $ascription->courses()->pluck('courses.id');
            $ids = $ids->concat($array);
        }
        $ids = $ids->unique();
        return Course::find($ids);
    }

    public function hasAvailableAnotherCourse(){
        $ids = $this->availableCourses()->pluck('id');
        foreach($ids as $id){
            if( ! $this->isEnrolledInCourse($course)){
                return $course;
            }
        }
        return false;
    }

    public function nextRecommendedCourse(){
        $ascriptions = $this->allAscriptions;
        foreach($ascriptions as $ascription){
            $this->recommendations($ascription)->first();
        }
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
        if ($evaluation == null) { return "Evaluation doesn�t exist"; }
    }

    // public function ascriptions(){  // Return ascriptions that aren't 'diplomados'
    //     return $this->belongsToMany('App\Ascription')->where('has_constancy', 0)->withTimestamps();
    // }

    public function ascription(){
        return $this->belongsTo('App\Ascription');
    }

    // public function diplomados(){
    //     return $this->belongsToMany('App\Ascription')->where('has_constancy', 1)->withPivot('score', 'status')->withTimestamps();
    // }

    // public function allAscriptions(){
    //     return $this->belongsToMany('App\Ascription')->withPivot('score', 'status')->withTimestamps();
    // }

    // public function normalAscriptions(){
    //     return $this->ascriptions->where('has_constancy', 0); // Not diplomat
    // }

    // public function hasAscriptions(){
    //     if ($this->ascriptions->count() > 0) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    // public function ascription(){
    //     if($this->hasAscriptions()){
    //         return $this->ascriptions->first();
    //     }else{
    //         return null;
    //     }
    // }

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

    // public function hasAscription(){
    //     if ($this->ascriptions->count() > 0) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

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
    // public function hasAvailableCourse($course_id){
    //     $course = Course::find($course_id);
    //     if($course == null ){
    //         return false;
    //     }
    //     $ascription = $this->ascription();
    //     if ($ascription == null) {
    //         return false;
    //     }
    //     return $ascription->courses->contains($course_id);
    // }
    public function hasAvailableCourse($course_id){
        $course = Course::find($course_id);
        if($course == null ){
            return false;
        }
        $ascription = $this->ascription;
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
        if ($module == null) { return false; }
        if($this->modules->contains($module_id)){
            $this->modules()->detach($module_id);
        }
        $this->modules()->attach($module_id, ['status' => 1]);
        $this->tryToSetCourseComplete($module->course->id);
        return true;
    }

    public function hasCompletedTheModule($module_id){
        $pivot = ModuleUser::where('user_id', $this->id)->where('module_id', $module_id)->first();
        if($pivot == null) { return false; }
        if($pivot->status == 1){
            return true;
        }else{
            return false;
        }
    }

    public function completedModulesOfCourse($course_id){
        $course = Course::find($course_id);
        if($course == null){ return 0; }
        return $this->completedModules->whereIn('id', $course->modules->pluck('id'));
    }

    public function numCompletedModulesOfCourse($course_id){
        $course = Course::find($course_id);
        if($course == null){ return 0; }
        return $this->completedModules->whereIn('id', $course->modules->pluck('id'))->count();
    }

    public function hasCompletedTheModulesOfCourse($course_id){
        $course = Course::find($course_id);
        if($course == null){ return false; }
        $numModules = $course->modules->count();
        if($numModules == $this->numCompletedModulesOfCourse($course_id)){
            return true;
        }else{
            return false;
        }
    }

    public function tryToSetCourseComplete($course_id){
        if($this->hasCompletedTheModulesOfCourse($course_id)){
            $pivot = CourseUser::where('course_id', $course_id)->where('user_id', $this->id)->first();
            if($pivot == null) {
                // return false; 
                $this->courses()->attach($course_id, ['status' => 1]);
                return true;
            }
            $pivot->status = 1;
            $pivot->save();
            return true;
        }
        return false;
    }

    public function hasCourseComplete($course_id){
        if($this->progressInCourse($course_id) == 1){
            return true;
        }else{
            return false;
        }
    }

    public function state(){
        return $this->belongsTo('App\State');
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

    public function completedFinalEvaluationsFromCourse($course_id){
        $course = Course::find($course_id);
        if($course == null){ return 0; }
        $finalEvaluations = $course->finalEvaluations();
        $count = 0;
        foreach($finalEvaluations as $evaluation){
            if($this->hasThisEvaluationCompleted($evaluation->id)){
                $count++;
            }
        }
        return $count;
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

    // public function enrolInDiplomado($ascription_id){
    //     $ascripton = Ascription::find($ascription_id);
    //     if($ascription == null) { return false; }
    //     if($ascription->hasConstancy == 0){ return false; } // Not a diplomado
    //     $this->ascriptions()->attach($ascription_id);
    //     return true;
    // }

    // public function hasDiplomados(){
    //     if($this->diplomados->count() > 0){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }

    public function numCompletedCoursesOfAscription($ascription_id){
        $ascription = Ascription::find($ascription_id);
        if($ascription == null) { return 0; }
        $ascriptionCourses = $ascription->courses->pluck('id');
        return $this->completedCourses()->whereIn('courses.id', $ascriptionCourses)->count();
    }

    // public function firstDiplomado(){
    //     return $this->diplomados->first(); // Null if user doesn't have
    // }

    // public function hasDifferentAscriptions(){
    //     if($this->allAscriptions->count() > 1){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }

    // public function isEnrolledInDiplomado($ascription_id){
    //     return $this->diplomados->contains($ascription_id);
    // }

    // public function firstAscription(){
    //     return $this->allAscriptions->first();
    // }

    public function getFullNameAttribute() {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function recommendations(Ascription $ascription) {

        $userTags = collect();
        $recommendedCourses = collect();
        // Get all tags from assigned courses
        foreach($this->courses as $course) {
            foreach($course->tags as $tag) {
                $userTags->push($tag);
            }
        }

        // Sort results by tag
        $userTags = $userTags->groupBy('tag');

        $userTags->transform(function($item, $key) {
            $item['qty'] = $item->count();
            $item['tag'] = $key;
            return $item;
        });

        // Get all courses "tag_score"
        //$existenCourses = Course::whereNotIn('id', $this->courses->pluck('id'))->get();
        $assignedIds = $this->courses->pluck('id');
        $existenCourses = $ascription->courses;
        $existenCourses = $existenCourses->reject(function($value, $key) use ($assignedIds) {
            return $assignedIds->contains($value->id);
        });
        //dd($existenCourses, $assignedIds);
        foreach($existenCourses as $course) {
            $tag_score = 0;
            foreach($course->tags as $tag) {
                foreach($userTags as $userTag) {
                    if($userTag['tag'] == $tag->tag) {
                        $tag_score += $userTag['qty'];
                    }
                }
            }
            $course->tag_score = $tag_score;
            $recommendedCourses->push($course);
        }

        return $recommendedCourses->sortByDesc('tag_score')->take(5);

    }

    public function hasCompletedEvaluationsFromCourse($course_id){
        $course = Course::find($course_id);
        if($course == null){ return false; }
        foreach($course->finalEvaluations() as $evaluation){
            if( ! $this->hasThisEvaluationCompleted($evaluation->id) ){
                return false;
            }
        }
        return true;
    }

    public function hasCertificateForCourse($course_id){
        foreach($this->approvedCourses() as $approved){
            if($approved->id == $course_id){
                return true;
            }
        }
        return false;
    }
    
    public function finalEvaluationsFromCourse($course_id){
        $course = Course::find($course_id);
        if($course == null){ return false; }
        $finalEvaluations = $course->finalEvaluations();
        $count = 0;
        $evaluations = collect();
        foreach($finalEvaluations as $evaluation){
            if($this->hasThisEvaluationCompleted($evaluation->id)){
                $evaluations->push($evaluation->id);
            }
        }
        $start = EvaluationUser::where('user_id', $this->id)->whereIn('evaluation_id', $evaluations)->min('created_at');
        $end = EvaluationUser::where('user_id', $this->id)->whereIn('evaluation_id', $evaluations)->max('updated_at');
        return compact('start', 'end');
    }

    public function initialDate($course_id){
        $course = Course::find($course_id);
        if($course == null){ return false; }
        $finalEvaluations = $course->finalEvaluations();
        $count = 0;
        $evaluations = collect();
        foreach($finalEvaluations as $evaluation){
            if($this->hasThisEvaluationCompleted($evaluation->id)){
                $evaluations->push($evaluation->id);
            }
        }
        $start = EvaluationUser::where('user_id', $this->id)->whereIn('evaluation_id', $evaluations)->min('created_at');
        return $start;
    }

    public function lastAdvanceInCourse($course_id){
        $pivot = CourseUser::where('course_id', $course_id)->where('user_id', $this->id)->first();
        if($pivot == null){
            return null;
        }
        return $pivot->updated_at;
    }






















    public function notifications(){
        return $this->hasMany('App\Notification');
    }

    public function hasNotifications(){
        if($this->notifications()->count() > 0){
            return true;
        }
        return false;
    }

    public function hasNotificationsFromCourse($course_id){
        if($this->notifications()->where('course_id', $course_id)->count() > 0){
            return true;
        }
        return false;
    }

    public function lastNotificationFromCourse($course_id){
        return $this->notifications()->where('course_id', $course_id)->orderBy('updated_at', 'desc')->first();
    }

    public function monthReminderNotifications(){
        return $this->notifications()->where('type', 2)->get();
    }

    public function numMonthReminderNotifications($course_id){ // Not viewed notifications
        return $this->notifications()->where('type', 2)->where('viewed', 0)->where('course_id', $course_id)->where('viewed', 0)->count();        
    }

    public function monthReminderNotificationsOfCourse($course_id){
        return $this->notifications()->where('course_id', $course_id)->get();
    }

    public function weekReminderNotifications(){
        return $this->notifications()->where('type', 3)->get();
    }

    public function numWeekReminderNotifications($course_id){ // Not viewed notifications
        return $this->notifications()->where('type', 3)->where('course_id', $course_id)->count();
    }

    public function recommendationNotifications($course_id){
        return $this->notifications()->where('type', 1)->where('course_id', $course_id)->get();
    }

    public function hasRecommendationOfCourse($course_id){
        return $this->notifications()->where('type', 1)->where('course_id', $course_id)->count();
    }

    public function hasCallNotification(){
        if($this->notifications()->where('type', 4)->count()){
            return true;
        }
        return false;
    }

}
