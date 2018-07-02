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
        if(Auth::check()){ // If user is registered
            $user = Auth::user();
            if($user->enabled == 0){
                Auth::logout();
                return back()->with('error', 'Usuario deshabilitado');
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
                // if(session()->has('ascription_slug')){
                //     $slug = session('ascription_slug');
                //     if(Ascription::whereSlug($slug)->first() != null){
                //         return redirect()->route('student.home', $slug);
                //     }
                // }
                // if($user->hasDifferentAscriptions()){
                //     return redirect()->route('student.select.ascription');
                // }
                // $ascription = $user->ascription();
                // return redirect()->route('student.home', $ascription->slug);
            }
            return redirect('/');
        }
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if($user->enabled == 0){
                Auth::logout();
                return back()->with('error', 'Usuario deshabilitado');
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
                    return back()->with(
                        'error', 'Hubo un error con su perfil, por favor comuníquese con soporte '.config('constants.support_email'
                    ));
                }
                return redirect()->route('student.home', $ascription->slug);
                // if($user->last_profile_update == ''){
                //     return redirect()->route('student.update');
                // }
                // if($user->hasDifferentAscriptions()){
                //     return redirect()->route('student.select.ascription');
                // }
                // $ascription = $user->allAscriptions->first();
                // return redirect()->route('student.home', $ascription->slug);
            }

            // User has an invalid role
            Auth::logout();
            return redirect('/');
        } else {
            return back()->withInput()->with('error', 'Verifique sus datos');
        }
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
            return back()->with('msj', 
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
            return view('users_pages.login.newPassword', compact('user', 'email', 'token'));
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

    // public function example(){
    //     Mail::to("ricardo.allende.p@gmail.com")->send(new ResetPasswordEmail( "www.google.com.mx" ));
    //     return "Email enviado";
    // }
}
