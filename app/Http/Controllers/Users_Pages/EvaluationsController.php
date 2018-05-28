<?php

namespace App\Http\Controllers\Users_Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Evaluation;
use App\User;
use App\EvaluationUser;
use App\QuestionUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EvaluationsController extends Controller
{
    public function showEvaluation($ascriptionSlug, $evaluation_id){
        $evaluation = Evaluation::find($evaluation_id);
        if($evaluation == null){ return redirect('/'); }
        return view('Users_Pages/evaluations/show', compact('evaluation'));
    }

    public function showAvailableEvaluations($ascriptionSlug){
        $user = Auth::user();
        $course = $user->courses->first();
        $evaluations = $course->evaluations();
        return view('users_pages/evaluations/list-evaluations', compact('user', 'course', 'evaluations'));
    }

    public function gradeEvaluation($ascriptionSlug, Request $request){
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


        echo "Número de preguntas: {$questions->count()} <br>";
        echo "Preguntas contestadas adecuadamente: {$summatory} <br>";
        echo "Promedio: {$evaluationAverage} <br>";
        echo "Calificación mínima: {$evaluation->minimum_score} <br>";  
        
        
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

        echo "Promedio del módulo: {$moduleAvg} <br>";
        $course->calculateAvgForUser($user_id);
    }

}
