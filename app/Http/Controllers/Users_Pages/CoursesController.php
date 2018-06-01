<?php

namespace App\Http\Controllers\Users_Pages;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Course;
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
    public function index($adscription_slug){ // List all courses the user is enrolled in
        $user = Auth::user();
        $search = "";
        if (isset($_GET['s'])) { // Filter by name or category
            $search = $_GET['s'];
            $categories = Category::where('name', 'like', "%{$search}%")->pluck('id');
            // dd($category);
            // $categoryFilter = function($query) use ($search) {
            //     $query->where('name', 'like', '%'.$search.'%');
            // }; // If the search includes the category
            // $categoryFilter = function($query) { $query->where('name', 'like', '%sistema%'); };
            $courses = $user->courses()->where('name', 'like', '%'.$search.'%')->get();
            // ->orWhereIn('category_id', $categories)->get();
            // dd($courses);
            // $courses = $user->courses()->where('name', 'like', '%'.$search.'%')
            //     ->orWhereHas('category', $categoryFilter)->get();
            // dd($courses->toSql());
            // $courses = $user->courses()->where('name','like','%'.$search.'%')->get();
        }else{
            $courses = $user->courses;
        }
        // dd($courses);
        return view('users_pages/courses.list',compact('courses', 'search'));
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

    

}
