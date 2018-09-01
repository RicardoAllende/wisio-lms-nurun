<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Diploma;
use App\Ascription;

class DiplomasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $diplomas = Diploma::all();
        return view('diplomados.list', compact('diplomas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ascriptions = Ascription::cursor();
        return view('diplomados.form', compact('ascriptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $diploma = Diploma::create($request->input());
        if($request->filled('attachment')){
            $attach_id = $request->input('attachment');
            $diploma->attachment_id = $attach_id;
            $diploma->save();
        }
        return view('diplomados.show', compact('diploma'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $diploma = Diploma::find($id);
        if($diploma == null){
            return redirect()->route('diplomas.index');
        }
        dd($diploma);
        return view('diplomados.show', compact('diploma'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $diploma = Diploma::find($id);
        if($diploma == null){
            return redirect()->route('diplomas.index');
        }
        $ascriptions = Ascription::cursor();
        return view('diplomados.form', compact('diploma', 'ascriptions'));
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
        $updateFields = $request->except('_token', 'attachment');
        if($request->filled('attachment')){
            $attach_id = $request->input('attachment');
            $diploma->attachment_id = $attach_id;
            $diploma->save();
        }
        Diploma::whereId($id)->update($updateFields);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Diploma::destroy($id);
        return redirect()->route('diplomas.index');
    }

    public function attachToAscription($ascription_id, $course_id){
        return "Attaching $ascription_id (ascription) from course_id $course_id";
    }

    public function detachForAscription($ascription_id, $course_id){
        return "Detaching $ascription_id (ascription) from course_id $course_id";
    }

}
