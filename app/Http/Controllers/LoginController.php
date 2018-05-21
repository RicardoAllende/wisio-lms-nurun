<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display the login page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::orderBy('created_at','desc')->limit(5)->get();
        return view('users_pages/login/login', compact('courses'));
    }

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
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if($user->isAdmin()){
                return redirect()->route('admin.dashboard');
            }
            if($user->isStudent()){
                $ascription = $user->ascription();
                return redirect()->route('student.home', $ascription->slug);
            }
        }else {
            return back();
            // return redirect()->route('form.login')->withErrors('Error al autenticar');
        }
    }

    public function userLogout(){
        Auth::logout();
        return redirect();
    }
}
