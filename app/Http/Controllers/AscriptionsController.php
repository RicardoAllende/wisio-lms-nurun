<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ascription;

class AscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ascriptions = Ascription::all();
        return view('ascriptions/list', ['ascriptions'=>$ascriptions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ascriptions/form');
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
        $ascription = Ascription::Create($input);
        $slug = str_slug($request->input('name'));
        $ascription->slug = $slug;
        $ascription->save();
        $ascriptionId = $ascription->id;
        return redirect()->action('AscriptionsController@show', $ascriptionId);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ascription = Ascription::find($id);
        if($ascription != null){
            return view('ascriptions/show', ['ascription' => $ascription]);
            // return "Mostrando la adscripción número {$id}";
        }else{
            return "Esta adscripción ha sido eliminada o no existe";
        }
        
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
        $ascription = Ascription::find($id);
        if($ascription != null){
            $ascription->delete();
            return redirect()->route('ascriptions.index');
        }
    }

}
