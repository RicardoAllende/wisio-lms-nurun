<?php

namespace App\Http\Middleware;

use Closure;

class PublicDoctor
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
        $user = Auth::user();
        if($user->hasRole(config('constants.roles.public_doctor'))){
            return $next($request);
        }else{
            return redirect()->route('permission.denied');
        }
    }
}
