<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = Auth::user();
            if($user->enabled == 0){
                Auth::logout();
                return back()->with('error', 'Usuario deshabilitado');
            }
            // if( ! $user->is_validated){
            //     return back()->with('msj', 'En este momento su usuario no está autenticado');
            // }
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
                $ascription =  $user->ascription;
                if($ascription == null){
                    Auth::logout();
                    return back()->with('error', 'Hubo un error con su perfil, por favor comuníquese con soporte '.config('constants.support_email'));
                }
                return redirect()->route('student.home', $ascription->slug);
                // if($user->last_profile_update == ''){
                //     return redirect()->route('student.update');
                // }
                // if(session()->has('ascription_slug')){
                //     $slug = session('ascription_slug');
                //     if(Ascription::whereSlug($slug)->first() != null){
                //         return redirect()->route('student.home', $slug);
                //     }
                // }
                // if($user->hasDifferentAscriptions()){
                //     return redirect()->route('student.select.ascription');
                // }
                // $ascription = $user->ascription();
                // return redirect()->route('student.home', $ascription->slug);
            }
            // User has an invalid role
            Auth::logout();
            return redirect('/');
            // return redirect('/');
        }
        return $next($request);
    }
}
