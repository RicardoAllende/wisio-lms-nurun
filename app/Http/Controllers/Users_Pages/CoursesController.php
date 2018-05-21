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
    public function index($adscription_slug)
    {
        $courses = Course::all();

        return view('users_pages/courses.list',compact('courses'));

    }

    public function show($adscription_slug, $course_slug)
    {
        $course = Course::where('slug', $course_slug);
        if($course == null){ return redirect()->route('users_pages/courses.list'); }
        return view('users_pages/courses.show',compact('course'));
    }

    public function recommendations($adscription_slug)
    {
        $courses = Course::all();
        return view('users_pages/courses.list',compact('courses'));
    }
}
