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
        return view('courses/list',compact('courses'));
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
        return redirect()->route('courses.show', $course_id);
        //dd($course);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {   
        
        return view('courses/show',compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $ammount = $course->length_ammount;
        $arrLength = explode(' ',$ammount);
        $course['amount'] = $arrLength[0];
        $course['unit'] = $arrLength[1];

        return view('courses/form',compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {

        $amount = $request->amount;
        $unit = $request->unit;

        switch ($unit) {
            case 'minutes':
                    $length = $amount;
                break;
            case 'hours':
                    $length= $amount * 60;
                break;
            case 'days':
                    $length = $amount * 1440;
                break;
            default:
                
                break;
        }

        $course->name = $request->name;
        $course->description = $request->description;
        $course->date_start = $request->date_start;
        $course->date_end = $request->date_end;
        //$course->featured_image = $request->featured_image;
        $course->featured = $request->featured;
        $course->weight = $request->weight;
        $course->category_id = $request->category_id;
        $course->difficulty = $request->difficulty;
        $course->length = $length;
        $course->save();
        $this->uploadImageCourse($course->id,$request->featured_image);
        return redirect('/courses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect('/courses');
    }

    public function uploadImage(Request $request){
        $imagePath = request()->file('file')->store('temps');
        echo $imagePath;
        
    }

    

    public function uploadImageCourse($course_id,$path){
        //Storage::makeDirectory($course_id);
        //$arrPath = explode('.', $path);
        $newPath = 'courses/'.$course_id.'/'.substr($path, strrpos($path, "/") + 1);
        //dd($path.'   '.$newPath);
        Storage::move($path,"public/".$newPath);
        Storage::delete($path);
        $course = Course::find($course_id);
        //$course->featured_image = 'storage/'.$course_id.'/'.$newPath;
        $course->featured_image = 'storage/'.$newPath;
        $course->save();
    }


    public function addToAscription($ascription_id){
        // $ascription = Ascription::findOrFail($ascription_id);
        $courses = Course::all();
        return view('courses/add-to-ascription', compact('courses', 'ascription_id'));
        // if($ascription->courses->count() > 0 ){
        //     return "Esta ascripción tiene más de 1 elemento";
        // }else{
        //     $courses = Course::all();
        //     return view('courses/add-to-ascription',compact('courses', 'ascription'));
        //     return "Se envian todos los cursos para poder agregarlos";
        // }
        // return view('courses/add-to-ascription');
        // return "Se agregarán cursos a la adscripción ".$ascription->name;
    }

    public function createForAscription($ascription_id){
        $ascription = Ascription::find($ascription_id);
        if ($ascription != null) {
            return view('courses/form', compact('ascription_id'));
        }
    }

}
