<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Response;
use Closure;

class AdminApi
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
                return Response::noAuthorizedResponse();
                return redirect()->route('permission.denied');
            }
        }else{
            return redirect('/');
        }
        // if($user->isAdmin()){

        // }
        // return $next($request);
    }
}
