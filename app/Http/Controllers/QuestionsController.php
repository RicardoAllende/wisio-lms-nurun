<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Answer;
use Illuminate\Support\Facades\Storage;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$categories = Category::all();
        return view('questions/uploadquestions');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
    
    public function insertQuestions($path){
        $content = $this->getContent($path);
        while(strpos($content, "::Q") !== false){
            $tipo = $this->tipoLinea($content);
            $content = substr($content, 6);
            $posicion = (strpos($content, "::") === false ) ? strlen($content) : strpos($content, "::");
            $questionContent = substr($content, 0, $posicion);
            $question = substr($questionContent ,0, strpos($questionContent, "{"));
            if ($tipo == 2) {
                $options = substr($questionContent , strpos($questionContent, "{") + 1);
                $options = str_replace("}", "", $options);
                $correct = $this->findCorrect($options);
                $options = $this->multiexplode(array("~","="),$options);
                $options = $this->dropEmpties($options);
                $question = Question::create([
                    'question' => trim($question, " \t\n\r") ,
                    'type' => $tipo,
                    'correct' => $this->indexOfCorrect($options, $correct )
                ]);
                $question = $question->id;
                $contador = 0;
                foreach ($options as $option) {
                    Answer::firstOrCreate([
                        'question_id' => $question,
                        'answer' => $option,
                        'position' => $contador
                    ]);
                    $contador++;
                }
            }else{
                $options = substr($questionContent , strpos($questionContent, "{") + 1);
                if(stripos($options, 'T') === false){
                    $question = Question::create([
                        'question' => trim($question, " \t\n\r") ,
                        'type' => $tipo,
                        'correct' => 0
                    ]);
                }else{
                    $question = Question::create([
                        'question' => trim($question, " \t\n\r") ,
                        'type' => $tipo,
                        'correct' => 1
                    ]);
                }
                

            }
            $content = substr($content, strpos($content, "::Q"));
        }
    }
    
    public function findCorrect($options){
        $start = "";
        $end = "";
        $correct = "";
        $size = strlen($options);
        $correct = substr($options, strpos($options, "=") + 1);
        if (strpos($correct, "~") !== false) {
            $correct = substr($correct, 0, strpos($correct, "~"));
        }
        return trim($correct);
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
