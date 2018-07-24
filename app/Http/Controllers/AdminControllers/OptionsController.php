<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Option;
use App\Question;

class OptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('options/list', ['options' => Option::cursor()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (isset($_GET['question_id'])) {
            $question_id = $_GET['question_id'];
            $question = Question::find($question_id);
            if( $question != null){
                return view('questions/form', compact('question'));
            }
        }
        return view("options/form", ["questions" => Question::all()]);
    }


    public function createFor($id){
        $question = Question::find($id);
        if($question == null){ return redirect()->route('options.create'); }
        return view('options/form', ['question' => $question, 'questions' => Question::all()]);
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
        $option = Option::create($input);
        return redirect()->route("questions.show", $option->question->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $option = Option::find($id);
        if($option == null){
            return redirect('/');
        }
        return view("options/show", ['option' => $option]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $option = Option::find($id);
        if($option == null){ return redirect('/'); }
        return view("options/form", ['option'=> $option, "questions" => Question::all()]);
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
        //dd($request->input());
        $option = Option::find($id);
        if($option == null){
            return redirect()->route('options.index');
        }
        $option->content = $request->content;
        if($request->filled('score')){
            $option->score = $request->score;
        }else{
            $option->score = 0;
        }
        //$option->type = $request->type;
        $option->save();
        return redirect()->route("options.show", $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $option = Option::find($id);
        if($option != null){
            $option->delete();
        }
        return back();
    }

    public function delete($id){
        $option = Option::find($id);
        if($option == null){
            return back()->withErrors([
                'error' => 'No se pudo eliminar la opción, inténtelo de nuevo.'
            ]);
        }
        $option->delete();
        return back();
    }

}