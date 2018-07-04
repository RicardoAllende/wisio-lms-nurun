<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
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
Use App\User;
use App\CertificateTemplate;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $templates = CertificateTemplate::all();
        return view('courses/form',compact('categories', 'templates'));
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
        $slug = str_slug($request->slug);
        if(Course::whereSlug($slug)->count() > 0){ // Slug already exists
            return back()->withErrors(['M1'=>'El slug ya existe'])->withInput();
        }
        $course = Course::create($input);
        $course->slug = str_slug($request->slug);
        $course->save();
        $course_id = $course->id;
        if($request->filled('attachment')){
            $attach_id = $request->input('attachment');
            $this->dropImgAttachments($course);
            AttachmentCourse::create(['attachment_id' => $attach_id, 'course_id' => $course_id]);
        }
        if ($request->filled('ascription_id')) {
            $ascription_id = $request->input('ascription_id');
            $ascription = Ascription::find($ascription_id);
            if ($ascription != null){
                AscriptionCourse::Create(['ascription_id' => $ascription_id, 'course_id' => $course_id]);
                return redirect()->route('ascriptions.show', $ascription_id);
            }
        }
        return redirect()->route('courses.show', $course_id);
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
        return view('courses/show',compact('course'));
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
        $templates = CertificateTemplate::all();
        return view('courses/form',compact('categories', 'templates', 'course'));
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
        $newSlug = str_slug($request->slug);
        if($course->slug != $newSlug ){
            $numFound = Course::where('slug', $newSlug)->count(); // If the slug already exists
            if ($numFound > 0) {
                return back()->withErrors(['error'=> 'Slug < {$newSlug} > repetido, debe ser único'])->withInput();
            }
        }
        $course->name = $request->name;
        $course->description = $request->description;
        $course->start_date = $request->start_date;
        $course->end_date = $request->end_date;
        $course->minimum_score = $request->minimum_score;
        $course->support_email = $request->support_email;
        $course->slug = str_slug($request->slug);
        $course->category_id = $request->category_id;
        $course->has_constancy = $request->has_constancy;
        if($request->filled('certificate_template_id')){
            $id = $request->certificate_template_id;
            $template = CertificateTemplate::find($id);
            if($template != null){
                $course->certificate_template_id = $request->certificate_template_id;
            }
        }
        if($request->filled('attachment')){
            $attach_id = $request->input('attachment');
            $this->dropImgAttachments($course);
            AttachmentCourse::create(['attachment_id' => $attach_id, 'course_id' => $course_id]);
        }
        $course->has_diploma = $request->has_diploma;
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
            return view('courses/form', compact('ascription', 'categories'));
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
        $images = $course->attachments->where('type', config('constants.attachments.main_img'));
        foreach($images as $image){
            $image->delete();
        }
    }

    public function disableCourse($course_id){
        $course = Course::find($course_id);
        if($course != null){
            $course->enabled = 0;
            $course->save();
        }
        return back();
    }

    public function enableCourse($course_id){
        $course = Course::find($course_id);
        if($course != null){
            $course->enabled = 1;
            $course->save();
        }
        return back();
    }

    public function listUsers($course_id){
        $users = User::all();
        $course = Course::find($course_id);
        if($course == null) { return redirect()->route('courses.index'); }
        return view('courses/list-users', compact('course', 'users'));
    }

    public function searchCourses($search){
        $categoryFilter = function($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%');
            }; // If the search includes the category
        return Course::where('name', 'like', '%'.$search.'%')
            ->orWhereHas('category', $categoryFilter)->with('category')->get()->toJson();
    }

    public function showReportAllCourses(){
        $courses = Course::all();
        return view('courses/report-all', compact('courses'));
    }

    public function reportCourse($course_id){
        $course = Course::find($course_id);
        if($course == null) { return redirect()->route('list.courses.report'); }
        $users = $course->users;
        return view('courses/report', compact('course', 'users'));
    }

    public function mail(){
        echo env('MAIL_DRIVER').'<br>';
        echo env('MAIL_HOST').'<br>';
        echo env('MAIL_PORT').'<br>';
        echo env('MAIL_USERNAME').'<br>';
        echo env('MAIL_PASSWORD').'<br>';
        echo env('MAIL_ENCRYPTION').'<br>';
    }

    public function manageDiplomaModules($course_id){
        $course = Course::find($course_id);
        if($course == null){
            return redirect()->route('courses.index');
        }
        if( ! $course->has_diploma){
            return redirect('courses.index')->withErrors(
                ['error' => "El diplomado {$course->name} no ofrece diploma, cambie su configuración e inténtelo de nuevo"]
            );
        }
        return view('courses.manage-diploma-modules', compact('course'));
    }

}
