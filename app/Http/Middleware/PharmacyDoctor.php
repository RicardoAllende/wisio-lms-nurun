<?php

namespace App\Http\Middleware;

use Closure;

class PharmacyDoctor
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
        if($user->hasRole(config('constants.roles.pharmacy_doctor'))){
            return $next($request);
        }else{
            return redirect()->route('permission.denied');
        }
    }
}
