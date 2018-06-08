<?php

namespace App\Http\Controllers;
use App\Course;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $courses = Course::orderBy('created_at','desc')->limit(5)->get();
        if(Auth::check()){
            $user = Auth::user();
            if($user->hasDiplomados()){
                $ascription = $user->diplomados->first();
                return view('users_pages/login/login', compact('courses', 'ascription'));
            }
            $ascription = $user->ascription();
            return view('users_pages/login/login', compact('courses', 'ascription'));
        }
        return view('users_pages/login/login', compact('courses'));
    }

    public function minor()
    {
        return view('home/minor');
    }
}