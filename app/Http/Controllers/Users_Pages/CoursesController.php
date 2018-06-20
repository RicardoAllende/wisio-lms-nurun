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
    public function index($ascription_slug)
    {
        $search = "";
        $user = Auth::user();
        if (isset($_GET['s'])) {
            $search = $_GET['s'];
            $courses = $user->courses()->where('name','like','%'.$search.'%')->get();
        }else{
            $courses = $user->courses;
        }
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        return view('users_pages/courses/list',compact('courses', 'search', 'ascription'));
    }

    public function show($ascription_slug, $course_slug)
    {
        $course = Course::where('slug', $course_slug)->first();
        if($course == null){ return view('users_pages/courses.list'); }
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        if(Auth::check()){
            $user = Auth::user();
            return view('users_pages/courses.show',compact('course', 'ascription', 'user'));
        }
        return view('users_pages/courses.show',compact('course', 'ascription'));
    }

    public function recommendations($ascription_slug)
    {
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        $courses = $ascription->courses;
        return view('users_pages/courses.home',compact('courses', 'ascription'));
    }

    public function enrollment($ascription_slug,$user_id, $course_id)
    {
      $course = Course::find($course_id);

      $enrol = $course->enrolUser($user_id);
      if($enrol){
        return back()->with('msj', 'Se realizó exitosamente la inscripción');
      } else {
        return back()->with('msj', 'No se pudo inscribir');
      }
    }

    public function publicCourses(){
        $courses = Course::whereIsPublic(1)->get();
        return view('users_pages/courses.list',compact('courses'));
        return $courses;
    }

    public function saveProgressModule(Request $request){
        $module = Module::find($request->module_id);
        $user = Auth::user();
        $save = null;

        if($request->status){
            $save = $user->setModuleComplete($request->module_id);
        }
        return $user->progressInModule($module->id);
        // if($save){
        //     return "Módulo completado";
        // }else{
        //     return "Módulo incompleto, revise las evaluaciones";
        // }
    }

    public function howItWorks($ascription_slug){
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        return view('users_pages.funciona', compact('ascription'));
    }

    public function getCourses($ascription_slug){
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        if($ascription == null){ return collect(); }
        $user = Auth::user();
        return $user->coursesFromAscription($ascription);
    }

}
