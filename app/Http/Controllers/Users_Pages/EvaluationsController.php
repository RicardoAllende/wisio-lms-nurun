<?php

namespace App\Http\Controllers\Users_Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Evaluation;
use App\User;
use App\EvaluationUser;
use App\QuestionUser;
use App\Ascription;
use App\CourseUser;
use App\Course;
use App\Module;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EvaluationsController extends Controller
{
    public function showCourses($ascription_slug){
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        $user = Auth::user();
        if($ascription == null) { return redirect()->route('student.home', $user->ascriptionSlug()); }
        $courses = $user->courses;
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        return view('Users_Pages/evaluations/list', compact('evaluations', 'courses', 'user', 'ascription'));
    }

    // public function showAvailableEvaluations($ascription_slug, $courseSlug){
    //     $user = Auth::user();
    //     $course = Course::whereSlug($courseSlug)->first();
    //     $evaluations = $course->evaluations();
    //     return view('users_pages/evaluations/list', compact('user', 'course', 'evaluations'));
    // }

    public function showEvaluationsFromCourse($ascription_slug, $courseSlug){
        $user = Auth::user();
        $course = Course::whereSlug($courseSlug)->first();
        $numModules = $course->modules->count();
        $completedModules = $user->completedModulesOfCourse($course->id);
        $modulesAdvance = number_format($completedModules / $numModules * 100, 2);
        $evaluations = $course->evaluations();
        $numEvaluations = $evaluations->count();
        $completedEvaluations = $user->completedEvaluationsForCourse($course->id);
        $enrollment = CourseUser::where('user_id', $user->id)->where('course_id', $course->id)->first();
        if($enrollment == null){ $evaluationsAdvance = '-'; } else { $evaluationsAdvance = $enrollment->score; }
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        return view('users_pages/evaluations/list-from-course',
        compact('user', 'course', 'numModules', 'completedModules', 'modulesAdvance', 
        'numEvaluations', 'completedEvaluations', 'evaluations', 'evaluationsAdvance',
        'ascriptionSlug', 'courseSlug', 'ascription'));
    }

    public function gradeEvaluation($ascription_slug, Request $request){
        $attempt_id = $request->attempt_id;
        $user_id = $request->user_id;
        $evaluation_id = $request->evaluation_id;
        $evaluation = Evaluation::find($evaluation_id);
        if($evaluation == null){
            return "No existe evaluación";
        }
        $user = User::find($user_id);
        if($user == null){
            return "No existe usuario";
        }

        if( ! $user->hasAnotherAttemptInEvaluation($evaluation_id)){
            return "Sin posibilidades de hacer esta evaluación nuevamente";
        }

        $evaluationAttempt = EvaluationUser::create(['evaluation_id' => $evaluation_id, 'user_id' => $user_id]);
        $questions = $evaluation->questions;

        // calculating the evaluation average
        $summatory = 0;
        foreach ($questions as $question) {
            $id = "question".$question->id;
            if($request->filled($id)){
                $optionGiven = $request->input($id);
                $summatory += $question->scoreOfQuestion($optionGiven);
                QuestionUser::create([
                    'question_id' => $question->id,
                    'user_id' => $user_id,
                    'option_id' => $optionGiven,
                    'evaluation_user_id' => $evaluationAttempt->id
                ]);
            }
        }
        $evaluationAverage = $summatory / $questions->count()*10; //  0-10 scale
        $evaluationAttempt->score = $evaluationAverage;
        $evaluationAttempt->save();

        $numQuestions = $questions->count();

        // echo "Número de preguntas: {$numQuestions} <br>";
        // echo "Preguntas contestadas adecuadamente: {$summatory} <br>";
        // echo "Promedio: {$evaluationAverage} <br>";
        // echo "Calificación mínima: {$evaluation->course()->minimum_score} <br>";

        
        $module = $evaluation->module;
        $course = $module->course;
        $finalEvaluations = $module->finalEvaluations->pluck('id');
        $moduleAvg = DB::table('evaluation_user')->select(DB::raw('max(score) as score'))->where('user_id', $user_id)
            ->whereIn('evaluation_id', $finalEvaluations)->groupBy('evaluation_id')->get()->avg('score');

        if($user->modules->contains($module->id)){
            $user->modules()->detach($module->id);
        }

        if ($evaluation->isFinalEvaluation()) {
            $user->modules()->attach($module->id, ['status' => config('constants.status.completed'), 'score' => $moduleAvg]);
        }else{
            if($module->hasFinalEvaluation()){
                $user->modules()->attach($module->id, ['status' => config('constants.status.incomplete'), 'score' => $moduleAvg]);
            }else{
                $user->modules()->attach($module->id, ['status' => config('constants.status.complete'), 'score' => $moduleAvg]);
            }
        }

        $user->tryToSetCourseComplete($course->id);


        // echo "Promedio del módulo: {$moduleAvg} <br>";
        $course->calculateAvgForUser($user_id);
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        return view('users_pages/evaluations/result', 
            compact('numQuestions', 'summatory', 'evaluation', 'ascription',
            'evaluationAverage', 'course', 'module', 'ascriptionSlug', 'moduleAvg')
        );
    }

    public function dragForm($evaluation_id){
        $evaluation = Evaluation::find($evaluation_id);
        if ($evaluation == null) {
            return "Hubo un error, contacte con el administrador";
        }

        if(Auth::user()->hasAnotherAttemptInEvaluation($evaluation->id)){
            echo '<form action="'.route('grade.evaluation', Auth::user()->ascriptionSlug()).'" method="post">';
            echo csrf_field();
            echo '<input type="hidden" name="user_id" value="'.Auth::user()->id.'" >';
            echo '<input type="hidden" name="evaluation_id" value="'.$evaluation->id.'">';
            echo '<div class="row pad-left3">
            <h2 class="recientes">'.$evaluation->name.'</h2>

              <div class="row "><!-- Slideshow container -->
                <div class="card white slideshow-container col s12">';
            $numQuestions = $evaluation->questions->count();
            $questions = $evaluation->questions;
            foreach ($questions as $question) {
                echo '<div class="mySlides row">
                    <h6>'.$question->content.'</h6>';
                echo '<div class="col s9">';
                foreach($question->options as $option){
                    echo '
                    <p>
                            <input name="question'.$question->id.'" required type="radio" value="'.$option->id.'" id="o'.$option->id.'" />
                            <label for="o'.$option->id.'">'.$option->content.'</label>
                          </p>
                          ';

                }
                if ( $question == $questions->last() ) {
                    echo '<button class="btn btn-success">Calificar</button>';
                }
                echo '</div>
                        <div class="col s3 center">
                        <a class="purple-text" onclick="plusSlidesE(1)">Siguiente<hr class="line3"/></a>
                        </div>
                    </div>';
            }
            echo '</div>
                    </div><!-- End Slideshow container -->
                        <div style="text-align:center">';
            for($i = 1; $i <= $numQuestions; $i++){
                echo '<span class="circle-dot circle-not-selected" id="dot'.$i.'" onclick="currentSlideE('.$i.')"></span> ';
            }
            echo '</div>
                </div></form><!-- End pad-left3 -->
                <script>currentSlideE(1)</script>
                ';
        }else{
            echo '<h3>Ya no puede hacer esta evaluación nuevamente</h3>';
        }
    }
}
