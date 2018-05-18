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

class CoursesController extends Controller
{
    public function index()
    {
        $courses = Course::all();

        return view('users_pages/courses.list',compact('courses'));

    }

    public function show($id)
    {
        $course = Course::find($id);
        if($course == null){ return redirect()->route('users_pages/courses.list'); }
        return view('users_pages/courses.show',compact('course'));
    }

    public function recommendations()
    {
        $courses = Course::all();

        return view('users_pages/courses.list',compact('courses'));

    }
}
