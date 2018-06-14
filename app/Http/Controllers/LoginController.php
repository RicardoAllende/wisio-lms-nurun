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
        if(Auth::check()){
            $user = Auth::user();
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
            return redirect('/');
        }
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            session(['info' => $user->email]);
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
                if($user->hasDifferentAscriptions()){
                    return redirect()->route('student.select.ascription');
                }
                $ascription = $user->ascription();
                return redirect()->route('student.home', $ascription->slug);
            }
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
}
