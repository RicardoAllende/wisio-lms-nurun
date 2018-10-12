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
use App\Notification;
use App\Mail\ApprovedCourse;
use App\Mail\NotApproved;
use App\Mail\SecondNotApproved;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Category;
use App\Tag;
use App\CourseTag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\AttachmentCourse;
use App\AscriptionCourse;
use App\CategoryCourse;
use Illuminate\Support\Facades\Mail;
use App\Mail\Enrollment;
use App\Diploma;
use App\DiplomaUser;


class EvaluationsController extends Controller
{
    public function showCourses($ascription_slug){
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        $user = Auth::user();
        if($ascription == null) { return redirect()->route('student.home', $user->ascriptionSlug()); }
        $courses = $user->coursesFromAscription($ascription);
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        return view('users_pages/evaluations/list', compact('evaluations', 'courses', 'user', 'ascription'));
    }

    public function showEvaluationsFromCourse($ascription_slug, $courseSlug){
        $user = Auth::user();
        $course = Course::whereSlug($courseSlug)->first();
        $pivot = CourseUser::where('course_id', $course->id)->where('user_id', $user->id)->first();
        if($pivot != null){ // User not enrolled
            if($pivot->status){
                if($pivot->updated_at == ''){
                    $now = \Carbon\Carbon::now()->toDateTimeString();
                    $pivot->updated_at = $now;                    
                }
            }else{
                $now = \Carbon\Carbon::now()->toDateTimeString();
                $pivot->updated_at = $now;
            }
            $pivot->save();
        }
        $numModules = $course->modules->count();
        $numCompletedModules = $user->numCompletedModulesOfCourse($course->id);
        $modulesAdvance = number_format($numCompletedModules / $numModules * 100, 2);
        $pivot = CourseUser::where('course_id', $course->id)->where('user_id', $user->id)->first();
        $completedModules = $user->completedModulesOfCourse($course->id);
        // $evaluations = $course->evaluations();
        // $evaluations = $course->finalEvaluations();
        $evaluations = collect();
        foreach($completedModules as $module){
            // dd($module->finalEvaluations()->first());
            if($module->hasFinalEvaluation()){
                $evaluations->push($module->finalEvaluations->first());
            }
        }
        // Mailing for reboot or not-approved-notification
        $msg = "";
        if($user->hasCourseComplete($course->id)){
            if($user->hasCompletedEvaluationsFromCourse($course->id)){
                $score = $user->scoreInCourse($course->id);
                if($score != ''){ //Course hasn't final evaluations
                    if($user->scoreInCourse($course->id) >= $course->minimum_score ){
                        if( ! $user->hasApprovedNotification($course->id)){ // Approved
                            $token = \Uuid::generate()->string;
                            $url = route('ascription.login', $user->ascription->slug);
                            Notification::create(['code' => $token, 'user_id' => $user->id, 'course_id' => $course->id, 'type' => 'approved']);
                            Mail::to($user->email)->send(new ApprovedCourse($url, $course->name));
                        }
                    } else{ // Not approved
                        if( ! $user->hasRebootInCourse($course->id)){
                            if( ! $user->hasNotApprovedNotification($course->id)){ // notification was sent
                                $token = \Uuid::generate()->string;
                                Notification::create(['code' => $token, 'user_id' => $user->id, 'course_id' => $course->id, 'type' => 'not_approved']);
                                $route = route('ascription.login', $ascription_slug)."?notification=".$token;
                                Mail::to($user->email)->send(new NotApproved($route, $course->name, $user->full_name)); // It has course reboot
                                $msg = "No aprobó este curso, verifique su correo electrónico para acceder a un segundo intento";
                            }
                        }else{
                            if( ! $user->hasSecondNotApprovedNotification($course->id)){ // notification was sent, user can't reboot the course
                                $token = \Uuid::generate()->string;
                                Notification::create(['code' => $token, 'user_id' => $user->id, 'course_id' => $course->id, 'type' => 'second_not_approved']);
                                $route = route('ascription.login', $ascription_slug)."?notification=".$token;                       
                                Mail::to($user->email)->send(new SecondNotApproved($route, $course->name));
                            }
                        }
                    }
                }
            }
        }
        $evaluations = $evaluations->sortBy('id');
        $numEvaluations = $course->finalEvaluations()->count();
        $completedEvaluations = $user->completedFinalEvaluationsFromCourse($course->id);
        $enrollment = CourseUser::where('user_id', $user->id)->where('course_id', $course->id)->first();
        if($enrollment == null){ $evaluationsAdvance = '-'; } else { $evaluationsAdvance = $enrollment->score; }
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        return view('users_pages/evaluations/list-from-course',
        compact('user', 'course', 'numModules', 'numCompletedModules', 'modulesAdvance',
        'numEvaluations', 'completedEvaluations', 'evaluations', 'evaluationsAdvance',
        'ascription_slug', 'courseSlug', 'ascription', 'msg'));
    }

    public function showFinalEvaluation($ascription_slug, $course_slug, $module_id){
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        if($ascription == null)  return redirect('/');
        $course = Course::whereSlug($course_slug)->first();
        if($course == null) return redirect('/');
        $user = Auth::user();
        $module = Module::find($module_id);
        $evaluation = $module->finalEvaluations->first();
        if($evaluation == null){
            return back();
        }
        $maximum_attempts = $evaluation->maximum_attempts;
        $numTries = $user->numTriesInEvaluation($evaluation->id);
        $score = $user->scoreInEvaluation($evaluation->id);
        if($numTries > $maximum_attempts){
            $numTries = $maximum_attempts;
        }
        if($numTries == 0){
            $score = "";
        }
        if($module == null) return redirect()->route('show.evaluation.course', [$ascription_slug, $course_slug]);
        return view('users_pages.evaluations.final-evaluation', 
        compact('ascription', 'course', 'evaluation', 'user', 'module', 'maximum_attempts', 'numTries', 'score'));
    }

    public function gradeEvaluation($ascription_slug, Request $request){
        $attempt_id = $request->attempt_id;
        $evaluation_id = $request->evaluation_id;
        $evaluation = Evaluation::find($evaluation_id);
        if($evaluation == null){
            return back();
        }
        $user = Auth::user();
        $user_id = $user->id;
        if($evaluation->isDiplomaEvaluation()){
            $course = $evaluation->diploma;
        }else{
            $module = $evaluation->module;
            $course = $module->course;
        }
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        if( ! $user->hasAnotherAttemptInEvaluation($evaluation_id)){
            $error = "Usted ya no puede realizar esta evaluación nuevamente";
            return view('users_pages/evaluations/error', compact('error', 'evaluation', 'ascription', 'diploma'));
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
        

        // ------------------------- Grading evaluation for diploma, it's stored in score_in_diploma
        if($evaluation->isDiplomaEvaluation()){
            $diploma = $evaluation->diploma;
            $diplomaEnrollment = DiplomaUser::where('diploma_id', $diploma->id)->where('user_id', $user->id)->first();
            
            $diplomaEnrollment->score = $evaluationAverage;
            $diplomaEnrollment->score = $user->scoreInEvaluation($evaluation->id);
            $diplomaEnrollment->status = true;
            $diplomaEnrollment->ended_at = now();
            $diplomaEnrollment->save();

            return view('users_pages/evaluations/diploma-result',
            compact('numQuestions', 'summatory', 'evaluation', 'ascription',
            'evaluationAverage', 'diploma', 'ascriptionSlug')
            );
        }
        //------------------------- End grading evaluation for diploma

        $module = $evaluation->module;
        $course = $module->course;
        $finalEvaluations = $module->finalEvaluations->pluck('id');
        $moduleAvg = DB::table('evaluation_user')->select(DB::raw('max(score) as score'))->where('user_id', $user_id)
            ->whereIn('evaluation_id', $finalEvaluations)->groupBy('evaluation_id')->get()->avg('score');

        if($user->modules->contains($module->id)){
            $user->modules()->detach($module->id);
        }

        if ($evaluation->isFinalEvaluation()) {
            $user->modules()->attach($module->id, ['status' => 1, 'score' => $moduleAvg]);
        }else{
            if($module->hasFinalEvaluation()){
                $user->modules()->attach($module->id, ['status' => 0, 'score' => $moduleAvg]);
            }else{
                $user->modules()->attach($module->id, ['status' => 0, 'score' => $moduleAvg]);
            }
        }

        $user->tryToSetCourseComplete($course->id);


        // echo "Promedio del módulo: {$moduleAvg} <br>";
        $course->calculateAvgForUser($user_id);
        if($evaluation->isDiagnosticEvaluation()){
            return view('users_pages/evaluations/diagnostic-result',
                compact('numQuestions', 'summatory', 'evaluation', 'ascription',
                'evaluationAverage', 'course', 'module', 'ascriptionSlug', 'moduleAvg')
            );
        }
        // Final Evaluation from module
        return view('users_pages/evaluations/result',
            compact('numQuestions', 'summatory', 'evaluation', 'ascription',
            'evaluationAverage', 'course', 'module', 'ascriptionSlug', 'moduleAvg')
        );
    }

    public function drawForm($ascription_slug, $courseSlug, $evaluation_id){
        $evaluation = Evaluation::find($evaluation_id);
        if ($evaluation == null) {
            echo "Hubo un error, contacte con el administrador ".config('constants.support_email');
            return;
        }
        if($evaluation->questions()->count() == 0){
            echo "<br><br><h2 class='recientes'> Esta evaluación está en mantenimiento, por favor contacte con ".config('constants.support_email')." <h2><br><br>";
            return;
        }

        if(Auth::user()->hasAnotherAttemptInEvaluation($evaluation->id)){
            if($evaluation->isDiagnosticEvaluation()){
                echo '<h4>Evaluación diagnóstica</h4>';
            }
            echo '<form action="'.route('grade.evaluation', $ascription_slug).'" id="formulario_evaluacion" method="post">';
            echo csrf_field();
            echo '<input type="hidden" name="evaluation_id" value="'.$evaluation->id.'">';
            echo '<div class="row pad-left3">
            <h2 class="recientes">'.$evaluation->name.'</h2>
              <div class="row "><!-- Slideshow container -->
                <div class="card white slideshow-container col s12">';
            $numQuestions = $evaluation->questions->count();
            $questions = $evaluation->questions->shuffle();
            $i = 1;
            foreach ($questions as $question) {
                echo '<div class="mySlides row">
                    <h6>'.$i.'. '.$question->content.'</h6>'; $i++;
                echo '<div class="col s9">';
                foreach($question->options->shuffle() as $option){
                    echo '
                    <p>
                        <input name="question'.$question->id.'" class="question'.$question->id.'" required type="radio" value="'.$option->id.'" id="o'.$option->id.'" />
                        <label for="o'.$option->id.'">'.$option->content.'</label>
                    </p>';
                }
                if ( $question == $questions->last() ) {
                    echo '<button class="btnAcademia" id="btnCalificar">Calificar</button>
                        </div>
                            <div class="col s3 center">
                            </div>
                        </div>';
                }else{
                    echo '</div>
                            <div class="col s3 center">
                            <a class="purple-text" onclick="plusSlidesE(1)">Siguiente<hr class="line3"/></a>
                            </div>
                        </div>';
                }
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

            echo '<script>
            $("#btnCalificar").click(function (event) {
                var error = false;
                var preguntas = "No se han respondido las preguntas: ";
                ';
            $i = 1;
            foreach($questions as $question){
                echo 'if( ! $(".question'.$question->id.'").is(":checked")) {  
                        preguntas += " '.$i.' ";
                        // alert("No se ha seleccionado la pregunta'.$i.'");
                        error = true;
                    } else {  
                        // alert("Todo en orden");
                    }';
                $i++;
            }
            echo '
                if(error){
                    Materialize.toast( preguntas ,4000,"error")
                    event.preventDefault();
                }else{
                    $("#formulario_evaluacion").submit();
                }
            });
            </script>';

            if($evaluation->isDiagnosticEvaluation()){
                echo '<script>
                $("#btnOmitir").hide();
                $("#btnX").hide();
                $( "#formulario_evaluacion" ).submit(function( event ) {
                    event.preventDefault();
                    $("#btnOmitir").show();                    
                    $("#btnX").show();
                    $("#btnOmitir").html("Comenzar módulo");
                    var actionForm = $("#formulario_evaluacion").attr("action");
                    var questions = $("#formulario_evaluacion").serializeArray();
                    $.ajax({
                        url: actionForm,
                        method: "post",
                        data: questions,
                        success: function(result){
                            $("#modalEvDiag .modal-content").html(result);
                        },
                        error: function(error){
                          console.log(error)
                        }
                    });
                  });
                </script>';
            }
        }else if(Auth::user()->scoreInEvaluation($evaluation->id)>=8){
            echo '<h3>Esta evaluación ya ha sido aprobada con: '.Auth::user()->scoreInEvaluation($evaluation->id).'</h3>';
        }
        else{
            echo '<h3>Ya no puede hacer esta evaluación nuevamente</h3>';
        }
    }

    public function drawDiplomaEvaluation($ascription_slug, $diplomaSlug){
        $user = Auth::user();
        $diploma = Diploma::whereSlug($diplomaSlug)->first();
        if($diploma == null){
            echo "Hubo un error, contacte con el administrador ".config('constants.support_email');
            return;
        }

        $evaluation = $diploma->evaluation;
        if ($evaluation == null) {
            echo "<br><br><h2 class='recientes'> Esta evaluación está en mantenimiento, por favor contacte con ".config('constants.support_email')." <h2><br><br>";
            return;
        }
        if($evaluation->questions()->count() == 0){
            echo "<br><br><h2 class='recientes'> Esta evaluación está en mantenimiento, por favor contacte con ".config('constants.support_email')." <h2><br><br>";
            return;
        }

        if($user->hasAnotherAttemptInEvaluation($evaluation->id)){
            echo '<h4>Evaluación para obtener el diplomado</h4>';
            echo '<form action="'.route('grade.evaluation', $ascription_slug).'" id="formulario_evaluacion" method="post">';
            echo csrf_field();
            echo '<input type="hidden" name="evaluation_id" value="'.$evaluation->id.'">';
            echo '<div class="row pad-left3">
            <h2 class="recientes">'.$evaluation->name.'</h2>
              <div class="row "><!-- Slideshow container -->
                <div class="card white slideshow-container col s12">';
            $numQuestions = $evaluation->questions->count();
            $questions = $evaluation->questions->shuffle();
            $i = 1;
            foreach ($questions as $question) {
                echo '<div class="mySlides row">
                    <h6>'.$i.'. '.$question->content.'</h6>'; $i++;
                echo '<div class="col s9">';
                foreach($question->options->shuffle() as $option){
                    echo '
                    <p>
                        <input name="question'.$question->id.'" class="question'.$question->id.'" required type="radio" value="'.$option->id.'" id="o'.$option->id.'" />
                        <label for="o'.$option->id.'">'.$option->content.'</label>
                    </p>';
                }
                if ( $question == $questions->last() ) {
                    echo '<button class="btnAcademia" id="btnCalificar">Calificar</button>
                        </div>
                            <div class="col s3 center">
                            </div>
                        </div>';
                }else{
                    echo '</div>
                            <div class="col s3 center">
                            <a class="purple-text" onclick="plusSlidesE(1)">Siguiente<hr class="line3"/></a>
                            </div>
                        </div>';
                }
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

            echo '<script>
            $("#btnCalificar").click(function (event) {
                var error = false;
                var preguntas = "No se han respondido las preguntas: ";
                ';
            $i = 1;
            foreach($questions as $question){
                echo 'if( ! $(".question'.$question->id.'").is(":checked")) {  
                        preguntas += " '.$i.' ";
                        // alert("No se ha seleccionado la pregunta'.$i.'");
                        error = true;
                    } else {  
                        // alert("Todo en orden");
                    }';
                $i++;
            }
            echo '
                if(error){
                    Materialize.toast( preguntas ,4000,"error")
                    event.preventDefault();
                }else{
                    $("#formulario_evaluacion").submit();
                }
            });
            </script>';

        }else{
            echo '<h3>Ya no puede hacer esta evaluación nuevamente</h3>';
        }
    }

    /**
     * Return 'true' if module has evaluation and user hasn´t done that evaluation yet
     * else returns 'false'
     */
    public function checkDiagnosticEvaluation($module_id){
        $module = Module::find($module_id);
        if($module == null){
            return "no";
        }
        if($module->hasDiagnosticEvaluation()){
            $user = Auth::user();
            // Expecting only one evaluation
            $evaluation = $user->diagnosticEvaluations()->first();
            if($user->hasThisEvaluationCompleted($evaluation)){
                return "no";
            }else{
                return "yes";
            }
        }else{
            return "no";
        }
    }

    /**
     * Return 'yes' if module has evaluation and user hasn´t done that evaluation yet
     * else returns 'no'
     */
    public function checkFinalEvaluation($module_id){
        $module = Module::find($module_id);
        if($module == null){
            return "no";
        }
        if($module->hasDiagnosticEvaluation()){
            $user = Auth::user();
            // Expecting only one evaluation
            $evaluation = $user->diagnosticEvalautions()->first();
            if($user->hasThisEvaluationCompleted($evaluation)){
                return "no";
            }else{
                return "yes";
            }
        }else{
            return "no";
        }
    }

}
