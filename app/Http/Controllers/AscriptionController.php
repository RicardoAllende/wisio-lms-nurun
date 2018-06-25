<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ascription;
use App\Course;
use Illuminate\Support\Facades\Auth;

class AscriptionController extends Controller
{

    public function mainRegisterForm(){
        $ascription = Ascription::whereIsMainAscription(1)->first();
        if($ascription == null){
            return "Hubo un error con la información en la base de datos, por favor contacte al administrador del sistema";
        }
        $courses = $ascription->courses; // Academia mc
        return view('Users/register', compact('courses', 'ascription'));
    }

    public function showContent($ascription_slug){
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        if($ascription == null) { return redirect('/'); }
        $courses = $ascription->courses;
        return view('users_pages/login/login', compact('courses', 'ascription'));
    }

    public function registerForm($ascription_slug){
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        if($ascription == null) { return redirect('/'); }
        return view('Users/register', compact('ascription'));
        // return "Nuevo usuario para la adscripción ".$ascription_slug;
    }

    public function registerFormWithCode($ascription_slug, $code){
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        if($ascription == null) { return redirect('/'); }
        return view('Users/register', compact('ascription', 'code'));
    }
}
