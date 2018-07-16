<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Evaluation;
use App\Question;


class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('questions/list', ['questions' => Question::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (isset($_GET['evaluation_id'])) {
            $evaluation_id = $_GET['evaluation_id'];
            $evaluation = Evaluation::find($evaluation_id);
            if($evaluation != null){
                return view('questions/form', compact('evaluation'));
            }
        }
        return view('questions/form', ['evaluations' => Evaluation::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->input();
        $question = Question::create($input);
        return redirect()->route('questions.show', $question->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::find($id);
        if($question == null){
            return redirect('/');
        }
        return view("questions/show", ['question' => $question]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::find($id);
        if($question == null){ return redirect()->route('questions.index'); }
        return view('questions/form', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::find($id);
        if($question != null){
            $question->delete();
        }
        return back();
        // return "Se eliminará el registro {$id}";
    }

    public function formGift(){
        return view('questions/uploadquestions');
    }

    public function uploadQuestions(Request $request){
        $questions = Question::count();
        $path = request()->file('file')->store('public/questions');
        $publicPath = "storage/questions/".substr($path, strrpos($path, "/") + 1);
        $this->insertQuestions($publicPath);
        Storage::delete($path);
        $totalQuestions = Question::count();
        return "Se agregaron ".($totalQuestions - $questions)." preguntas";
    }

    public function getContent($path){
        $lineas = file($path);
        $text = "";
        for ($i=0; $i < sizeof($lineas); $i++) {
            if ($this->tipoLinea($lineas[$i]) != 0) {
                if ($lineas[$i] != '') {
                    $text .= $lineas[$i];
                }
            }
        }
        return $text;
    }
    
    public function indexOfCorrect($options, $correct){
        $i = 0;
        foreach ($options as $option) {
            if ($option == $correct) {
                return $i;
            }
            $i++;
        }
        return "Not found";
    }
    
    public function dropEmpties($array){
        $return = array();
        foreach ($array as $element) {
            if($element != ""){
                array_push($return, trim($element));
            }
        } return $return;
    }
    
    public function tipoLinea($linea){
        if(substr($linea, 0,2) == "//"){
            return 0;//Comentario
        }
        if(substr($linea, 0,6) == "::Q1::"){
            return 1;// Falso verdadero
        }
        if(substr($linea, 0,6) == "::Q2::"){
            return 2;// Opción múltiple
        }
        return -1;
    }
    
    public function multiexplode ($delimiters,$string) {
        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return  $launch;
    }

}
