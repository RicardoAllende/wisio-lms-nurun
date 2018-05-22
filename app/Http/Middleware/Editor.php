<?php

namespace App\Http\Middleware;

use Closure;

class Editor
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
            if($user->hasRole(config('constants.roles.editor'))){
                return $next($request);
            }else{
                return redirect()->route('permission.denied');
            }
        }else{
            return redirect('/');
        }
    }
}
