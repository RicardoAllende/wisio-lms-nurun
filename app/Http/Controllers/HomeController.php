<?php

namespace App\Http\Controllers;
use App\Course;
use Illuminate\Support\Facades\Auth;
use App\Ascription;

class HomeController extends Controller
{
    public function index()
    {
        $ascription = Ascription::whereIsMainAscription(1)->first();
        if($ascription == null){
            return "Hubo un error con la información en la base de datos, por favor contacte al administrador del sistema";
        }
        $courses = $ascription->courses; // Academia mc
        // $courses = Course::orderBy('created_at','desc')->limit(5)->get();
        if(Auth::check()){
            $user = Auth::user();
            if($user->enabled == 0){
                Auth::logout();
            }
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
        }
        return view('users_pages/login/login', compact('courses', 'ascription'));
    }

    public function minor()
    {
        return view('home/minor');
    }

    public function privacity($ascription_slug){
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        return view('users_pages.legals.privacidad', compact('ascription'));
    }

    public function terms($ascription_slug){
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        return view('users_pages.legals.terminosycondiciones', compact('ascription'));
    }
    
    public function pharmacovigilance($ascription_slug){
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        return view('users_pages.legals.farmacovigilancia', compact('ascription'));
    }

    public function twitterTerms($ascription_slug){
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        return view('users_pages.legals.twitter', compact('ascription'));
    }

}