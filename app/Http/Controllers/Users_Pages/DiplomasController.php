<?php

namespace App\Http\Controllers\Users_Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ascription;
use App\Diploma;
use Illuminate\Support\Facades\Auth;

class DiplomasController extends Controller
{
    public function show($ascription_slug, $diploma_slug){
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        $diploma = Diploma::whereSlug($diploma_slug)->first();
        if($ascription == null || $diploma == null){
            return redirect('/');
        }
        if(Auth::check()){
            $user = Auth::user();
            if($user->diplomas->contains($diploma->id)){ // user is enrolled in course
                $enrollment = $user->diplomas->find($diploma->id);
                // dd($enrollment->evaluation);
                if($enrollment->pivot->status){ // User has the diploma evaluation finished
                    $finished = true;
                    return view('users_pages.diplomas.show', compact('ascription', 'diploma', 'enrollment', 'finished'));
                }
                if($enrollment->hasDiplomaEvaluation()){
                    return view('users_pages.diplomas.show', compact('ascription', 'diploma', 'enrollment'));
                }
            }
            if( $diploma->verifyUser($user->id) ){
                $invitation = true;
                return view('users_pages.diplomas.show', compact('ascription', 'diploma', 'invitation'));
            }
            return view('users_pages.diplomas.show', compact('ascription', 'diploma'));
        }
        return view('users_pages.diplomas.show', compact('ascription', 'diploma'));
        dd($diploma);
    }

    public function showDiplomaResult(Request $request, $ascription_slug, $diploma_slug){
        dd($request->input());
    }

    public function enrolUserInDiplomado($ascription_slug, $diploma_slug){
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        $diploma = Diploma::whereSlug($diploma_slug)->first();
        if($ascription == null || $diploma == null){
            return redirect('/');
        }
        $user = Auth::user();
        $user->diplomas()->attach($diploma->id);
        // $diploma->enrolUser($user->id);
        return "terminado";
        // if($diploma->enrolUser($user->id)){

        // }else{
        //     return back()->with('error', 'Hubo un problema con la creación de su certificado, por favor contacte con '.config('constants.support_email'));
        //     return back()->with('error', 'Desafortunadamente no cuenta con los requisitos previos para hacer el diplomado');
        // }
    }

}
