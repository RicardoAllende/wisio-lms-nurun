<?php

namespace App\Http\Controllers\Users_Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ascription;
use App\Diploma;

class DiplomasController extends Controller
{
    public function show($ascription_slug, $diploma_slug){
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        $diploma = Diploma::whereSlug($diploma_slug)->first();
        if($ascription == null || $diploma == null){
            return redirect('/');
        }
        dd($diploma);
    }

}
