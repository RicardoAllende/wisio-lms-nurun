<?php

namespace App\Http\Controllers;

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
        return view('options/list', ['options' => Option::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("options/form", ["questions" => Question::all()]);
        //
    }


    public function createFor($id){
        $question = Question::findOrFail($id);
        // return "Se agregará opción a la pregunta ".$id;
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
        return redirect()->route("options.show", Option::create($input)->id);
        // Para encontrar el último position de la pregunta: ->options->sortByDesc('position') // no permitir eliminar la correcta
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $option = Option::findOrFail($id);
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
        return view("options/form", ['option'=>Option::findOrFail($id), "questions" => Question::all()]);
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
        $option = Option::findOrFail($id);
        $option->name = $request->name;
        $option->type = $request->type;
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
        //Option::findOrFail(300);
        $option = Option::findOrFail($id);
        $question = $option->question->id;
        $option->delete();
        // return redirect()->action('OptionsController@index');
        return redirect()->action('QuestionsController@show', $question);
    }
}