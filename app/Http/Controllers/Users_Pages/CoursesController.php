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
            $user = Auth::user();
            if($user->ascription->id != $ascription->id){
                return redirect('/');
            }
            $pivot = CourseUser::where('course_id', $course->id)->where('user_id', $user->id)->first();
            if($pivot != null){ // User not enrolled
                $now = \Carbon\Carbon::now()->toDateTimeString();
                $pivot->updated_at = $now;
                $pivot->save();
            }
            if($user->hasCourseComplete($course->id)){
                if($user->hasCompletedEvaluationsFromCourse($course->id)){
                    if($user->scoreInCourse($course->id) >= $course->minimum_score ){
                        if($course->has_constancy){
                            if( ! $user->hasCertificateNotificationFromCourse($course->id)){
                                $recommendations = $user->nextRecommendations();
                                // if( $recommendations->isNotEmpty() ){ // notification is in certificate notification
                                //     $token = \Uuid::generate()->string;
                                //     Notification::create(['code' => $token, 'user_id' => $user->id, 'course_id' => $course->id, 'type' => 'recommendation']);
                                //     Mail::to($user->email)->send(new Recommendation($token, $recommendations, $user));
                                // }
                                $token = \Uuid::generate()->string;
                                Notification::create(['code' => $token, 'user_id' => $user->id, 'course_id' => $course->id, 'type' => 'certificate']);
                                Mail::to($user->email)->send(new ApprovedCourse($url, $recommendations, $user, $ascription->slug));
                            }
                            if($course->has_diploma){
                                $evaluation = $course->diplomaEvaluation;
                                if($evaluation != null){ // Course is finished
                                    return view('users_pages/courses.show',compact('course', 'ascription', 'user', 'evaluation'));
                                }
                            }
                        }
                    }
                }
            }
            return view('users_pages/courses.show',compact('course', 'ascription', 'user'));
        }
        return view('users_pages/courses.show',compact('course', 'ascription'));
    }

    public function recommendations($ascription_slug)
    {
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        if($ascription == null) { return redirect('/'); }
        $courses = $ascription->courses;
        $recommendations = Auth::user()->recommendations();
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
            $url = route('student.show.course', [$ascription_slug, $course->slug]);
            Mail::to($user->email)->send(new Enrollment($url, $course->name));
            return back()->with('msj', 'Se realizó exitosamente la inscripción');
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
