<?php

namespace App\Http\Controllers\Users_Pages;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Course;
use App\Module;
use App\Category;
use App\Ascription;
use App\Tag;
use App\CourseTag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\AttachmentCourse;
use App\AscriptionCourse;
use App\CategoryCourse;
use App\CourseUser;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Enrollment;
use App\Notification;
use App\Mail\ApprovedCourse;
use App\Mail\NotApproved;
use App\Mail\SecondNotApproved;


class CoursesController extends Controller
{
    public function index($ascription_slug)
    {
        $search = "";
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        if($ascription == null){
            return redirect('/');
        }
        $user = Auth::user();
        $courses = $user->coursesFromAscription($ascription);
        if (isset($_GET['s'])) {
            $search = $_GET['s'];
            if($search != ''){
                $coursesId = $user->coursesIdFromAscription($ascription);
                $courses = Course::where('name', 'like', '%'.$search.'%')->whereIn('id', $coursesId)->get();
                if($courses->isEmpty()){
                    $categories = Category::where('name', 'like', '%'.$search.'%')->pluck('id');
                    $coursesByCategory = Course::whereIn('id', $coursesId)->whereIn('category_id', $categories)->get();
                    if($coursesByCategory->isEmpty()){
                        $tags = Tag::where('tag', 'like', '%'.$search.'%')->pluck('id');
                        if($tags->isNotEmpty()){
                            $ids = CourseTag::whereIn('tag_id', $tags)->whereIn('course_id', $coursesId)->pluck('course_id');
                            $courses = Course::find($ids);
                        }
                    }else{
                        $courses = $coursesByCategory;
                    }
                }
            }
        }
        return view('users_pages/courses/list',compact('courses', 'search', 'ascription'));
    }

    public function show($ascription_slug, $course_slug)
    {
        $course = Course::where('slug', $course_slug)->first();
        if($course == null){ return view('users_pages/courses.list'); }
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        if( ! $ascription->hasCourse($course->id)){
            return redirect('/');
        }
        if(Auth::check()){
            $msg = "";
            $user = Auth::user();
            if($user->ascription->id != $ascription->id){
                return redirect('/');
            }
            $pivot = CourseUser::where('course_id', $course->id)->where('user_id', $user->id)->first();
            if($pivot != null){ // Saving advance
                if($pivot->status == false){
                    $now = \Carbon\Carbon::now()->toDateTimeString();
                    $pivot->updated_at = $now;
                    $pivot->save();
                }
            }else{
                return view('users_pages/courses.show',compact('course', 'ascription', 'user'));
            }
            if($user->hasCourseComplete($course->id)){
                if($user->hasCompletedEvaluationsFromCourse($course->id)){
                    $score = $user->scoreInCourse($course->id);
                    if($score != ''){ //Course hasn't final evaluations
                        if($user->scoreInCourse($course->id) >= $course->minimum_score ){
                            if( ! $user->hasApprovedNotification($course->id)){ // Approved
                                $token = \Uuid::generate()->string;
                                $url = route('ascription.login', $user->ascription->slug);
                                Notification::create(['code' => $token, 'user_id' => $user->id, 'course_id' => $course->id, 'type' => 'approved']);
                                Mail::to($user->email)->send(new ApprovedCourse($url, $course->name));
                            }
                            if($course->has_diploma){
                                $evaluation = $course->diplomaEvaluation;
                                if($evaluation != null){ // Course is finished
                                    if($user->hasAnotherAttemptInEvaluation($evaluation->id)){
                                        return view('users_pages/courses.show',compact('course', 'ascription', 'user', 'evaluation', 'msg'));
                                    }
                                }
                            }
                        } else{ // Not approved
                            if( ! $user->hasRebootInCourse($course->id)){
                                if( ! $user->hasNotApprovedNotification($course->id)){ // notification was sent
                                    $token = \Uuid::generate()->string;
                                    Notification::create(['code' => $token, 'user_id' => $user->id, 'course_id' => $course->id, 'type' => 'not_approved']);
                                    $route = route('ascription.login', $ascription_slug)."?notification=".$token;
                                    Mail::to($user->email)->send(new NotApproved($route, $course->name, $user->full_name)); // It has course reboot
                                    $msg = "No aprobó este curso, verifique su correo electrónico para acceder a un segundo intento";
                                }
                            }else{
                                if( ! $user->hasSecondNotApprovedNotification($course->id)){ // notification was sent, user can't reboot the course
                                    $token = \Uuid::generate()->string;
                                    Notification::create(['code' => $token, 'user_id' => $user->id, 'course_id' => $course->id, 'type' => 'second_not_approved']);
                                    $route = route('ascription.login', $ascription_slug)."?notification=".$token;                       
                                    Mail::to($user->email)->send(new SecondNotApproved($route, $course->name));
                                }
                            }
                        }
                    }else { 
                        // if( ! $user->hasApprovedNotification($course->id)){ // Approved
                        //     $recommendations = $user->nextRecommendations();
                        //     $token = \Uuid::generate()->string;
                        //     $url = "";
                        //     Notification::create(['code' => $token, 'user_id' => $user->id, 'course_id' => $course->id, 'type' => 'approved']);
                        //     Mail::to($user->email)->send(new ApprovedCourse($url, $recommendations, $user, $ascription->slug));
                        // }
                        $msg = "Curso terminado"; 
                    }
                }
            }
            return view('users_pages/courses.show',compact('course', 'ascription', 'user', 'msg'));
        }
        return view('users_pages/courses.show',compact('course', 'ascription'));
    }

    public function recommendations($ascription_slug)
    {
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        if($ascription == null) { return redirect('/'); }
        $courses = $ascription->courses;
        if(Auth::check()){
            $recommendations = Auth::user()->recommendations();
        }else{
            $recommendations = $courses;
        }
        return view('users_pages/courses.home',compact('courses', 'ascription', 'recommendations'));
    }

    public function enrollment($ascription_slug,$user_id, $course_id)
    {
        $user = User::find($user_id);
        if($user == null){ return back()->with('error', 'No se pudo realizar su inscripción en este momento'); }
        $course = Course::find($course_id);
        if($course == null) { return back()->with('error', 'No se pudo realizar su inscripción en este momento'); }
        $enrol = $course->enrolUser($user_id);
        if($enrol){
            $token = \Uuid::generate()->string;
            $url = route('ascription.login', $ascription_slug).'?notification='.$token;
            Notification::create(['code' => $token, 'user_id' => $user_id, 'course_id' => $course_id, 'type' => 'enrollment']);
            Mail::to($user->email)->send(new Enrollment($url, $course->name));
            return redirect()->route('student.show.course', [$ascription_slug, $course->slug]); // 
            // return back()->with('msj', 'Se realizó exitosamente la inscripción');
        } else {
            return back()->with('error', 'No se pudo inscribir');
        }
    }

    public function saveProgressModule(Request $request){
        $module = Module::find($request->module_id);
        $user = Auth::user();
        $save = null;
        $save = $user->setModuleComplete($request->module_id);
        return $user->progressInModule($module->id);
    }

    public function howItWorks($ascription_slug){
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        return view('users_pages.funciona', compact('ascription'));
    }

    public function getCourses($ascription_slug){
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        if($ascription == null){ return collect(); }
        $user = Auth::user();
        return $user->coursesFromAscription($ascription);
    }

}
