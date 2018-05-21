<?php

namespace App\Http\Controllers;
use App\Course;

class HomeController extends Controller
{
    public function index()
    {
        $courses = Course::orderBy('created_at','desc')->limit(5)->get();
        return view('users_pages/login/login', compact('courses'));
    }

    public function minor()
    {
        return view('home/minor');
    }
}