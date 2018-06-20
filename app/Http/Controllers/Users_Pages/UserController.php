<?php

namespace App\Http\Controllers\Users_Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ascription;
use Illuminate\Support\Facades\Auth;
use App\State;
use App\User;
use App\Role;

class UserController extends Controller
{
    public function updateInformation(){
        $user = Auth::user();
        $ascription = $user->ascription();
        return view('Users/update', compact('user', 'ascription'));
    }

    public function update(Request $request){
        $user = Auth::user();
        $user->gender = $request->gender;
        $user->state_id = $request->state_id;
        $user->specialty_id = $request->specialty_id;
        $user->consultation_type = $request->consultation_type;
        $user->mobile_phone = $request->mobile_phone;
        $user->postal_code = $request->postal_code;
        $user->city = $request->city;
        $user->address = $request->address;
        if($request->filled('password')){
            $user->password = bcrypt($request->password);
        }
        $dateTime = \Carbon\Carbon::now()->toDateTimeString();
        $user->last_profile_update = $dateTime;
        $user->save();
        if(session()->has('ascription_slug')){
            $slug = session('ascription_slug');
            if(Ascription::whereSlug($slug)->first() != null){
                return redirect()->route('student.home', $slug)->with('msj', 'Su información ha sido actualizada');
            }
        }
        if($user->hasDifferentAscriptions()){
            return redirect()->route('student.select.ascription')->with('msj', 'Su información ha sido actualizada');
        }
        $ascription = $user->ascription();
        return redirect()->route('student.home', $ascription->slug)->with('msj', 'Su información ha sido actualizada');
    }

    public function selectAscription(){
        $user = Auth::user();
        $ascriptions = $user->allAscriptions;
        $ascription = $user->allAscriptions->first();
        return view('users_pages/courses/diplomado', compact('ascriptions', 'user', 'ascription'));
    }

    public function setTemporalAscription($ascription_slug){
        session(['ascription_slug' => $ascription_slug]);
        return true;
    }

    public function getAllStates(){
        return State::all();
    }

    public function store(Request $request){
        $input = $request->input();
        $email = $request->email;
        if(User::whereEmail($email)->count() > 0 ){ // Email exists
            return back()->withInput()->with('error', "Email repetido, ya existe un usuario con email ".$email);
        }
        $cedula = $request->cedula;
        if(User::whereCedula($cedula)->count() > 0 ){ // Cédula exists
            return back()->withInput()->with('error', "Cédula repetida, ya existe un usuario con esa cédula");
        }
        $user = User::create($input);
        $user->lastname = $request->paterno.' '.$request->materno;
        $user->password = bcrypt($request->password);
        $user->role_id = Role::whereName(config('constants.roles.doctor'))->first()->id;
        $ascription = null;
        $dateTime = \Carbon\Carbon::now()->toDateTimeString();
        $user->last_access = $dateTime;
        $dateTime = \Carbon\Carbon::now()->toDateTimeString();
        $user->last_profile_update = $dateTime;
        if($request->filled('seccion')){
            $ascription = Ascription::whereSlug($request->seccion)->first();
        }
        if($ascription == null){
            $ascription = Ascription::first();  // Academia Sanofi
        }
        $user->ascriptions()->attach($ascription->id);
        $user->save();
        $email = $user->email;
        $password = $request->password;
        if(Auth::attempt(compact('email', 'password'))){
            return redirect('/');
        }
    }

}
