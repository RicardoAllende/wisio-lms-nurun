<?php

namespace App\Http\Controllers\Users_Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ascription;
use Illuminate\Support\Facades\Auth;
use App\State;

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
        $dateTime = \Carbon\Carbon::now()->toDateTimeString();
        $user->last_profile_update = $dateTime;
        $user->save();
        if(session()->has('ascription_slug')){
            $slug = session('ascription_slug');
            if(Ascription::whereSlug($slug)->first() != null){
                return redirect()->route('student.home', $slug);
            }
        }
        if($user->hasDifferentAscriptions()){
            return redirect()->route('student.select.ascription');
        }
        $ascription = $user->ascription();
        return redirect()->route('student.home', $ascription->slug);
    }

    public function selectAscription(){
        $user = Auth::user();
        $ascriptions = $user->allAscriptions;
        return view('users_pages/courses/diplomado', compact('ascriptions', 'user'));
    }

    public function setTemporalAscription($ascription_slug){
        session(['ascription_slug' => $ascription_slug]);
        return true;
    }

    public function getAllStates(){
        return State::all();
    }

}
