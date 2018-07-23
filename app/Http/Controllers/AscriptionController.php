<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ascription;
use App\Course;
use Illuminate\Support\Facades\Auth;
use App\Notification;
use App\CourseUser;
use Illuminate\Support\Facades\DB;
use App\User;

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
                if(Auth::check()){
                    $user = Auth::user();
                    if($notification->user_id == $user->id){
                        $notification->accessed = 1;
                        $notification->save();
                        switch($notification->type){
                            case 'recommendation':
                                // User is redirected normally
                            break;
                            case 'month_reminder':
                            case 'week_reminder':
                            case 'enrollment':
                                $course = Course::find($notification->course_id);
                                if($course == null){ return redirect('/'); }
                                $ascription = $user->ascription;
                                
                                if($ascription == null){ return redirect('/'); }
                                return redirect()->route('student.show.course', [$ascription->slug, $course->slug]);
                            break;
                            case 'certificate':
                            case 'diploma':
                            case 'approved':
                                $ascription_slug = $user->ascription->slug;
                                return redirect()->route('certificates.list', $ascription_slug);
                            break;
                            case 'not_approved': // second attempt in course
                                $course = Course::find($notification->course_id);
                                $pivot = CourseUser::where('user_id', $user->id)->where('course_id', $notification->course_id)->first();
                                if($pivot != null){
                                    if( ! $pivot->has_reboot){
                                        $user->resetAdvanceInCourse($course->id);
                                        $pivot->has_reboot = 1;
                                        $pivot->score = null;
                                        $pivot->save();
                                        $ascription_slug = $user->ascription->slug;
                                        return redirect()->route('show.evaluation.course', [$ascription_slug, $course->slug]);
                                    }
                                }
                            break;
                            case 'second_not_approved':
                                // No special action
                            break;
                        }
                    }
                    return redirect('/');
                }
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
