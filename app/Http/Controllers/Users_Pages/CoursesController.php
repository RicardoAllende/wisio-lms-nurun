<?php

namespace App\Http\Controllers\Users_Pages;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Course;
use App\Module;
use App\Category;
use App\Ascription;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\AttachmentCourse;
use App\AscriptionCourse;
use App\CategoryCourse;
use App\CourseUser;
use Illuminate\Support\Facades\Auth;

class CoursesController extends Controller
{
    public function index($adscription_slug)
    {
        $search = "";
        $user = Auth::user();
        if (isset($_GET['s'])) {
            $search = $_GET['s'];
            $courses = $user->courses()->where('name','like','%'.$search.'%');
        }else{
            $courses = $user->courses;
        }
        return view('users_pages/courses/list',compact('courses', 'search'));
    }

    public function show($adscription_slug, $course_slug)
    {
        $course = Course::where('slug', $course_slug)->first();
        if($course == null){ return view('users_pages/courses.list'); }
        return view('users_pages/courses.show',compact('course'));
    }

    public function recommendations($adscription_slug)
    {
        $courses = Course::all();
        return view('users_pages/courses.home',compact('courses'));
    }

    public function enrollment($slug,$user_id, $course_id)
    {
      $course = Course::find($course_id);

      $enrol = $course->enrolUser($user_id);
      if($enrol){
        return redirect()->back()->with('success', ['Se realizó exitosamente la inscripción']);
      } else {
        return redirect()->back()->with('error', ['No se pudo inscribir']);
      }
    }

    public function publicCourses(){
        $courses = Course::whereIsPublic(1)->get();
        return view('users_pages/courses.list',compact('courses'));
        return $courses;
    }

    public function saveProgressModule(Request $request){
      //dd($request);
      $module = Module::find($request->module_id);
      $save = $module->users()->attach(Auth::user()->id, ['status' => $request->status]);
      return $save;
    }



}
