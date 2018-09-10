<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class Student
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            $user = Auth::user();
            if($user->isStudent()){
                if($user->enabled){
                    return $next($request);
                }else{
                    Auth::logout();
                    return redirect('/');
                }
            }
        }
        return redirect('/');
    }
}
