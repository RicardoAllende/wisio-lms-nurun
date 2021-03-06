<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class Admin
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
            if($user->hasRole(config('constants.roles.admin'))){
                return $next($request);
            }else{
                return redirect()->route('permission.denied');
            }
        }else{
            return redirect('/');
        }
        
    }
}
