<?php

namespace App\Http\Controllers\Users_Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ascription;
use Illuminate\Support\Facades\Auth;

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
        $user->specialty_id = $request->specialty_id;
        $user->consultation_type = $request->consultation_type;
        $user->mobile_phone = $request->mobile_phone;
        $dateTime = \Carbon\Carbon::now()->toDateTimeString();
        $user->last_profile_update = $dateTime;
        $user->save();
        if($user->hasDifferentAscriptions()){
            return redirect()->route('student.select.ascription');
        }
        $ascription = $user->ascription();
        return redirect()->route('student.home', $ascription->slug);
    }

    public function selectAscription(){
        $user = Auth::user();
        $ascriptions = $user->allAscriptions;
        dd($ascriptions);
    }

}
