<?php

namespace App\Http\Controllers\Users_Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ascription;

class UserController extends Controller
{
    public function updateInformation(){
        return view('Users/update');
    }

    public function updateInfo(Request $request){
        dd($request->input());
    }

    public function selectAscription(){
        $user = Auth::user();
        $ascriptions = $user->allAscriptions;
        dd($ascriptions);
    }

}
