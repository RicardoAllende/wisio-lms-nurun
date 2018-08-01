<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\PasswordReset;
use App\Mail\ResetPasswordEmail;
use Illuminate\Support\Facades\DB;
use App\Notification;
use App\Course;
use App\CourseUser;
use App\Ascription;

class LoginController extends Controller
{
    /**
     * Display the login page.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     // $courses = Course::orderBy('created_at','desc')->limit(5)->get();
    //     // return view('users_pages/login/login', compact('courses'));
    //     return view('users_pages/login/login');
    // }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if(Auth::check()){ // If user is authenticated
            $user = Auth::user();
            if($user->enabled == 0){
                Auth::logout();
                return back()->with('error', 'Usuario deshabilitado');
            }
            if( ! $user->is_validated){
                return back()->with('msj', 'En este momento su usuario no está autenticado');
            }
            $dateTime = \Carbon\Carbon::now()->toDateTimeString();
            $user->last_access = $dateTime;
            $user->save();
            if($user->isAdmin()){
                return redirect()->route('admin.dashboard');
            }
            if($user->isStudent()){
                if($user->last_profile_update == ''){
                    return redirect()->route('student.update');
                }
                $ascription =  $user->ascription;
                if($ascription == null){
                    Auth::logout();
                    return back()->with('error', 'Hubo un error con su perfil, por favor comuníquese con soporte '.config('constants.support_email'));
                }
                return redirect()->route('student.home', $ascription->slug);
            }
            // User has an invalid role
            Auth::logout();
            return redirect('/');
        }
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if($user->enabled == 0){
                Auth::logout();
                return back()->with('error', 'Usuario deshabilitado');
            }
            if( ! $user->is_validated){
                return back()->with('msj', 'En este momento su usuario no está autenticado');
            }
            $dateTime = \Carbon\Carbon::now()->toDateTimeString();
            $user->last_access = $dateTime;
            $user->save();
            if($user->isAdmin()){
                return redirect()->route('admin.dashboard');
            }
            if($user->isStudent()){
                if($request->filled('notification')){
                    $notification = $request->notification;
                    $notification = Notification::whereCode($notification)->first();
                    if($notification != null){
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
                    }
                }
                if($user->last_profile_update == ''){
                    return redirect()->route('student.update');
                }
                $ascription =  $user->ascription;
                if($ascription == null){
                    Auth::logout();
                    return back()->with(
                        'error', 'Hubo un error con su perfil, por favor comuníquese con soporte '.config('constants.support_email')
                    );
                }
                return redirect()->route('student.home', $ascription->slug);
            }

            // User has an invalid role
            Auth::logout();
            return redirect('/');
        } else {
            return back()->withInput()->with('error', 'Verifique sus datos');
        }
    }

    public function forgotPassword(){
        $ascription = Ascription::whereIsMainAscription(1)->first();
        if($ascription == null){
            $ascription = Ascription::first();
        }
        // return $ascription;
        return view('users_pages.login.forgotPassword', compact('ascription'));
    }

    public function userLogout(){
        Auth::logout();
        return redirect('/');
        // return redirect()->route('welcome');
    }

    public function sendResetPasswordLink(Request $request){
        $email = $request->email;
        if(User::whereEmail($email)->count() == 1){
            $token = $this->createToken();
            $dateTime = \Carbon\Carbon::now()->toDateTimeString();
            DB::statement('DELETE FROM password_resets where email = "'.$email.'"');
            PasswordReset::create(['email' => $email, 'token' => $token, 'created_at' => $dateTime]);
            $token = route('set.new.password', $token);
            Mail::to($email)->send(new ResetPasswordEmail( $token ));
            return redirect()->route('login')->with('msj', 
            'Se le ha enviado un correo electrónico con el link para reestablecer su contraseña, verifique su correo no deseado en caso de que no lo encuentre');
        }else{
            return back()->with('error', 'Su correo no se encuentra inscrito en la plataforma');
        }
    }

    public function getResetPasswordLink($token){
        $reset = PasswordReset::whereToken($token)->first();
        if( $reset != null){ // It exists
            $email = $reset->email;
            $user = User::whereEmail($email)->first();
            $ascription = $user->ascription;
            return view('users_pages.login.newPassword', compact('user', 'email', 'token', 'ascription'));
        }else{
            return redirect('/')->with('error', 'Su código para reestablecer contraseña no es válido');
        }
    }

    public function setNewPassword(Request $request){
        $newPassword = $request->password;
        $confirmPassword = $request->password_confirm;
        if($newPassword != $confirmPassword){
            return back()->withInput()->with('error', 'Sus contraseñas no coinciden');
        }
        $email = $request->email;
        $user = User::whereEmail($email)->first();
        if($user != null){
            $user->password = bcrypt($newPassword);
            $user->save();
            DB::statement('DELETE FROM password_resets where email = "'.$email.'"');
            $credentials = $request->only('email', 'password');
            Auth::attempt($credentials);
            return redirect('/');
        }else{
            return back()->withInput()->with('error', 'Hubo un error, inténtelo de nuevo o contacte con soporte@paecmexico.com');
        }
    }

    public function createToken(){
        // do{
        $token = \Uuid::generate()->string;
        // }while(PasswordReset::whereToken($token)->count() > 0);
        return $token;
    }
}
