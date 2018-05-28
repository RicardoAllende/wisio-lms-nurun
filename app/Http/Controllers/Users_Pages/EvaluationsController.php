<?php

namespace App\Http\Controllers\Users_Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Evaluation;

class EvaluationsController extends Controller
{
    public function showEvaluation($evaluation_id){
        $evaluation = Evaluation::find($evaluation_id);
        if($evaluation == null){ return redirect('/'); }
        return view('Users_Pages/evaluations/show', compact('evaluation'));
    }
}
