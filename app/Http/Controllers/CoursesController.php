<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Category;
use App\Ascription;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\AttachmentCourse;
use App\AscriptionCourse;
use App\CategoryCourse;
use App\CourseUser;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $path;

    public function index()
    {
        $courses = Course::all();
        if($courses->count()>0){
            return view('courses/list',compact('courses'));
        }else{
            return redirect()->route('courses.create');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('courses/form',compact('categories'));
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
        $course_id = Course::create($input)->id;
        if($request->filled('attachment')){
            $attach_id = $request->input('attachment');
            AttachmentCourse::create(['attachment_id' => $attach_id, 'course_id' => $course_id]);
        }
        if ($request->filled('ascription_id')) {
            $ascription_id = $request->input('ascription_id');
            if (Ascription::find($ascription_id) != null){
                AscriptionCourse::Create(['ascription_id' => $ascription_id, 'course_id' => $course_id]);
            }
        }
        if ($request->filled('category_id')) {
            $category_id = $request->input('category_id');
            if (Category::find($category_id) != null){
                CategoryCourse::Create(['category_id' => $category_id, 'course_id' => $course_id]);
            }
        }
        return redirect()->route('courses.show', $course_id);
        //dd($course);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::find($id);
        if($course == null){ return redirect()->route('courses.index'); }
        $approved = CourseUser::where('course_id', $course->id)->where('status', 'visto')->count();
        return view('courses/show',compact('course', 'approved'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($course_id)
    {
        $course = Course::find($course_id);
        if($course == null){
            return redirect()->route('courses.index');
        }
        $categories = Category::all();
        return view('courses/form',compact('course', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $course_id)
    {
        $course = Course::find($course_id);
        if($course == null){
            return redirect()->route('courses.index');
        }
        $course->name = $request->name;
        $course->description = $request->description;
        $course->start_date = $request->start_date;
        $course->end_date = $request->end_date;
        if($request->filled('has_constancy')){
            $has_constancy = 1;
        }else{
            $has_constancy = 0;
        }
        $course->has_constancy = $has_constancy;
        $course->save();
        return redirect()->route('courses.show', $course_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //return "Eliminando el curso {$course->id}";
        try{
            $course->delete();
        }catch(\Illuminate\Database\QueryException $e){
            return "Error al intentar eliminar el curso, pertenece a alguna adscripción";
        }
        return redirect()->route('courses.index'); 
    }

    public function listForAscription($ascription_id){
        $ascription = Ascription::find($ascription_id);
        if($ascription==null){    return redirect()->route('ascriptions.index');    }
        $courses = Course::all();
        return view('courses/add-to-ascription', compact('courses', 'ascription'));
    }

    public function createForAscription($ascription_id){
        $ascription = Ascription::find($ascription_id);
        $categories = Category::all();
        if ($ascription != null) {
            return view('courses/form', compact('ascription_id', 'categories'));
        }
    }

    public function relateToAscription($course_id, $ascription_id){
        AscriptionCourse::create(['course_id' => $course_id, 'ascription_id'=>$ascription_id]);
        return back();
        return redirect()->route('list.courses.for.ascription', $ascription_id);
    }

    public function addToAscription(){

    }

    public function dissociateOfAscription($course_id, $ascription_id){
        $pivots = AscriptionCourse::where('ascription_id', $ascription_id)->where('course_id', $course_id)->get();
        foreach($pivots as $pivot){
            $pivot->delete();
        }
        return back();
        return redirect()->route('list.courses.for.ascription', $ascription_id);
    }

    public function dropImgAttachments($course){
        $images = $course->attachments->where('type', 'main_img');
        foreach($images as $image){
            $image->delete();
        }
    }

}