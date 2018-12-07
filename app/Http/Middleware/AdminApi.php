<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Response;
use Closure;
use Illuminate\Support\Facades\Auth;

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
            if($user->isAdmin()){
                return $next($request);
            }else{
                return Response::noAuthorizedResponse();
            }
        }else{
            return Response::noLoginResponse();
        }
    }
}
