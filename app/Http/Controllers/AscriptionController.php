<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ascription;
use App\Course;
use Illuminate\Support\Facades\Auth;
use App\Notification;

class AscriptionController extends Controller
{
    public $notificationTokenName = "notification";

    public function mainRegisterForm(){
        $ascription = Ascription::whereIsMainAscription(1)->first();
        if($ascription == null){
            return "Hubo un error con la información en la base de datos, por favor contacte al administrador del sistema";
        }
        return view('Users/register', compact('ascription'));
    }

    public function showContent($ascription_slug){
        if(Auth::check()){
            return redirect('/');
        }
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        if($ascription == null) { return redirect('/'); }
        $courses = $ascription->courses;
        return view('users_pages/login/login', compact('courses', 'ascription'));
    }

    public function login($ascription_slug){
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        if($ascription == null) { return redirect('/'); }
        $courses = $ascription->courses;
        if(isset($_GET[$this->notificationTokenName])){
            $notification = $_GET[$this->notificationTokenName];
            $notification = Notification::whereCode($notification)->first();
            if($notification != null){
                $notification->viewed = 1;
                $notification->save();
                return view('users_pages/login/login', compact('courses', 'ascription', 'notification'));
            }
        }
        return view('users_pages/login/login', compact('courses', 'ascription'));
    }

    public function registerForm($ascription_slug){
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        if($ascription == null) { return redirect('/'); }
        if(isset($_GET[$this->notificationTokenName])){
            $notification = $_GET[$this->notificationTokenName];
            return view('Users/register', compact('ascription', 'notification'));
        }
        return view('Users/register', compact('ascription'));
    }

    public function registerFormWithCode($ascription_slug, $code){
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        if($ascription == null) { return redirect('/'); }
        if(isset($_GET[$this->notificationTokenName])){
            $notification = $_GET[$this->notificationTokenName];
            return view('Users/register', compact('ascription', 'notification', 'code'));
        }
        return view('Users/register', compact('ascription', 'code'));
    }
}
