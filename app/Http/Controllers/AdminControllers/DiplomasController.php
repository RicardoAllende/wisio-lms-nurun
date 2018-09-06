<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Diploma;
use App\Ascription;
use App\Course;
use App\CertificateTemplate;

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
        $templates = CertificateTemplate::all();
        return view('diplomados.form', compact('ascriptions', 'templates'));
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
        $diploma->slug = str_slug($diploma->slug);
        if($request->filled('attachment')){
            $attach_id = $request->input('attachment');
            $diploma->attachment_id = $attach_id;
        }
        $diploma->save();
        $courses = $diploma->ascription->courses;
        return view('diplomados.show', compact('diploma', 'courses'));
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
        $courses = $diploma->ascription->courses;
        // dd($courses);
        // dd($diploma);
        return view('diplomados.show', compact('diploma', 'courses'));
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
        $templates = CertificateTemplate::all();
        $ascriptions = Ascription::cursor();
        return view('diplomados.form', compact('diploma', 'ascriptions', 'templates'));
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
        $updateFields = $request->except('_token', 'attachment', '_method');
        Diploma::whereId($id)->update($updateFields);
        $diploma = Diploma::find($id);
        if($diploma == null){
            return back()->withErrors(['error' => 'No se encontró el diploma']);
        }
        $diploma->slug = str_slug($diploma->slug);
        if($request->filled('attachment')){
            $diploma->attachment_id = $request->input('attachment');
        }
        $diploma->save();
        $courses = $diploma->ascription->courses;
        return view('diplomados.show', compact('diploma', 'courses'));
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

    public function attachToCourse($diploma_id, $course_id){
        $diploma = Diploma::find($diploma_id);
        if($diploma != null){
            $diploma->attachCourse($course_id);
        }
        return redirect()->route('diplomas.show', $diploma->id);
    }

    public function detachFromCourse($diploma_id, $course_id){
        $diploma = Diploma::find($diploma_id);
        if($diploma != null){
            $diploma->courses()->detach($course_id);
        }
        return redirect()->route('diplomas.show', $diploma->id);
    }

}
