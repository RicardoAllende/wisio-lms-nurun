<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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

        $amount = $input['amount'];
        $unit = $input['unit'];

        switch ($unit) {
            case 'minutes':
                    $input['length'] = $amount;
                break;
            case 'hours':
                    $input['length'] = $amount * 60;
                break;
            case 'days':
                    $input['length'] = $amount * 1440;
                break;
            default:
                
                break;
        }
    

        $path = $input['featured_image'];
        $courseId = Course::create($input)->id;

        $this->uploadImageCourse($courseId,$path);
        return redirect('/courses');
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

    

    public function uploadImageCourse($courseId,$path){
        //Storage::makeDirectory($courseId);
        //$arrPath = explode('.', $path);
        $newPath = 'courses/'.$courseId.'/'.substr($path, strrpos($path, "/") + 1);
        //dd($path.'   '.$newPath);
        Storage::move($path,"public/".$newPath);
        Storage::delete($path);
        $course = Course::find($courseId);
        //$course->featured_image = 'storage/'.$courseId.'/'.$newPath;
        $course->featured_image = 'storage/'.$newPath;
        $course->save();
    }
}
