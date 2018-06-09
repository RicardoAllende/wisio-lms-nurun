<?php

namespace App\Http\Controllers;
use App\Course;
use Illuminate\Support\Facades\Auth;
use App\Ascription;

class HomeController extends Controller
{
    public function index()
    {
        $courses = Course::orderBy('created_at','desc')->limit(5)->get();
        if(Auth::check()){
            $user = Auth::user();
            if($user->isAdmin()){
                return redirect()->route('admin.dashboard');
            }
            if($user->isStudent()){
                if($user->last_profile_update == ''){
                    return redirect()->route('student.update');
                }
                if(session()->has('ascription_slug')){
                    $slug = session('ascription_slug');
                    if(Ascription::whereSlug($slug)->first() != null){
                        return redirect()->route('student.home', $slug);
                    }
                }
                if($user->hasDifferentAscriptions()){
                    return redirect()->route('student.select.ascription');
                }
                $ascription = $user->ascription();
                return redirect()->route('student.home', $ascription->slug);
            }

            // $user = Auth::user();
            // if($user->hasDiplomados()){
            //     $ascription = $user->diplomados->first();
            //     return view('users_pages/login/login', compact('courses', 'ascription'));
            // }
            // $ascription = $user->ascription();
            // return view('users_pages/login/login', compact('courses', 'ascription'));
        }
        return view('users_pages/login/login', compact('courses'));
    }

    public function minor()
    {
        return view('home/minor');
    }
}