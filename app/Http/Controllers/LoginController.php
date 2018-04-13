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
        return view('login/login');
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
            return redirect()->action('UsersController@index');
        }else {
            return redirect()->route('form.login');
        }
    }

    public function userLogout(){
        Auth::logout();
        return redirect()->route('welcome');
    }
}