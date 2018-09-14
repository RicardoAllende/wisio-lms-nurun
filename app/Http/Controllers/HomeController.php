<?php

namespace App\Http\Controllers;
use App\Course;
use Illuminate\Support\Facades\Auth;
use App\Ascription;
use App\Notification;
use GuzzleHttp\Client;
use App\User;
use App\Http\Controllers\Janrain;

class HomeController extends Controller
{
    public $notificationTokenName = "notification";

    public function index()
    {
        $ascription = Ascription::whereIsMainAscription(1)->first();
        if($ascription == null){
            $ascription = Ascription::first();
            if($ascription == null){
                return "Hubo un error con la información en la base de datos, por favor contacte al administrador del sistema";
            }
        }
        $courses = $ascription->courses; // Academia mc
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
                $ascription = $user->ascription;
                return redirect()->route('student.home', $ascription->slug);
            }
        }
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

    public function siteMap($ascription_slug){
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        return view('users_pages.legals.sitemap', compact('ascription'));
    }

    // public function registerUser($email){
    //     $default_password = "Welcome123$";
    //     $janrain = new JanRain;
    //     dd($janrain->janrainRegister($email, $default_password));
    // }

    // public function attemptUser($email){
    //     $default_password = "Welcome123$";
    //     $janrain = new JanRain;
    //     dd($janrain->janrainLogin($email, $default_password));
    // }

    // public function verifyUser($email){
    //     $default_password = "Welcome123$";
    //     $janrain = new JanRain;
    //     dd($janrain->verifyEmailExists($email));
    // }

}
